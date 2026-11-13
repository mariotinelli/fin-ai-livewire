<?php

declare(strict_types = 1);

namespace App\Support\Alerts;

/** Filters diagnostic data; callers must not put unidentified secrets in free text. */
class AlertSanitizer
{
    private const string Redacted = '**********';

    /** @var list<string> */
    private array $secrets = [];

    /** @param array<array-key, mixed> $sources */
    public function __construct(array $sources = [])
    {
        $remaining = 1000;
        $this->collectSecrets($sources, $remaining);
        usort($this->secrets, static fn (string $left, string $right): int => strlen($right) <=> strlen($left));
    }

    public function text(?string $value, int $limit = 2000): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!mb_check_encoding($value, 'UTF-8')) {
            return self::Redacted;
        }

        $value = preg_replace('/-----BEGIN [^-]*PRIVATE KEY-----.*?(?:-----END [^-]*PRIVATE KEY-----|$)/s', self::Redacted, $value) ?? self::Redacted;
        $value = preg_replace('~\b(?:Bearer|Basic)\s+[^\s,;"\'<>]+~i', self::Redacted, $value) ?? self::Redacted;
        $value = preg_replace('~\beyJ[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\b~', self::Redacted, $value) ?? self::Redacted;
        $value = preg_replace_callback('~[a-z][a-z0-9+.-]*://[^\s<>"\']+~i', fn (array $match): string => $this->url($match[0]) ?? self::Redacted, $value) ?? self::Redacted;
        $value = preg_replace('/\b(?:authorization|(?:set[-_ ]?)?cookie)\s*[=:]\s*[^\r\n]+/i', self::Redacted, $value) ?? self::Redacted;
        $value = preg_replace_callback(
            '~(--[\w.-]+)\s+("[^"\r\n]*"|\'[^\'\r\n]*\'|[^\s]+)~',
            fn (array $match): string => $this->sensitiveKey($match[1]) ? $match[1] . '=' . self::Redacted : $match[0],
            $value,
        ) ?? self::Redacted;
        $value = preg_replace_callback(
            '~([\w.%\[\]-]+)["\']?\s*(?:[=:]|\s+(?=["\']))\s*("(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\'|[^\s&,;<>]+)~',
            fn (array $match): string => $this->sensitiveKey($match[1]) ? $match[1] . '=' . self::Redacted : $match[0],
            $value,
        ) ?? self::Redacted;
        $value = str_replace($this->secrets, self::Redacted, $value);

        return $this->truncate($value, $limit);
    }

    public function url(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!mb_check_encoding($value, 'UTF-8')) {
            return self::Redacted;
        }

        $value = explode('#', $value, 2)[0];
        $value = preg_replace('~(//)[^/?#]*@~', '$1' . self::Redacted . '@', $value) ?? self::Redacted;

        $parts = explode('?', $value, 2);

        if (isset($parts[1])) {
            $pairs    = preg_split('/[&;]/', $parts[1]) ?: [];
            $parts[1] = implode('&', array_map(function (string $pair): string {
                [$key, $value] = array_pad(explode('=', $pair, 2), 2, '');

                return $this->sensitiveKey($key)
                    ? $key . '=' . self::Redacted
                    : $key . (str_contains($pair, '=') ? '=' . rawurlencode($this->text(urldecode($value)) ?? self::Redacted) : '');
            }, $pairs));
        }

        return $this->truncate(str_replace($this->secrets, self::Redacted, implode('?', $parts)), $this->limit('url_limit', 2048));
    }

    /** @param array<array-key, mixed> $data
     * @return array<array-key, mixed>
     */
    public function context(array $data): array
    {
        $remaining = $this->limit('context_items', 100);

        return $this->sanitizeArray($data, $remaining);
    }

    public function trace(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        /** Remove complete argument lists, including multiline values, from legacy traces. */
        $value = preg_replace('/((?:\):|\]:)\s*[^\r\n(]+)\(.*?\)(?=\r?\n#|$)/s', '$1(' . self::Redacted . ')', $value) ?? self::Redacted;

        return $this->text($value, $this->limit('trace_limit', 12000));
    }

    public function limit(string $key, int $maximum): int
    {
        return max(1, min(config()->integer('alerts.redaction.' . $key, $maximum), $maximum));
    }

    private function sensitiveKey(string $key): bool
    {
        $normalized = strtolower(preg_replace('/[^a-z0-9]/i', '', urldecode($key)) ?? '');
        $keys       = ['password', 'passwd', 'passphrase', 'token', 'secret', 'authorization', 'cookie', 'apikey', 'privatekey', 'credential', 'session', 'csrf', 'xsrf', 'signature'];

        /** @var list<string> $additionalKeys */
        $additionalKeys = config('alerts.redaction.sensitive_keys', []);

        foreach (array_merge($keys, $additionalKeys) as $sensitive) {
            $sensitive = strtolower(preg_replace('/[^a-z0-9]/i', '', $sensitive) ?? '');

            if ($sensitive !== '' && str_contains($normalized, $sensitive)) {
                return true;
            }
        }

        return false;
    }

    /** @param array<array-key, mixed> $data
     * @return array<array-key, mixed>
     */
    private function sanitizeArray(array $data, int &$remaining, int $depth = 0): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            if ($remaining-- <= 0) {
                $result['__truncated__'] = true;

                break;
            }

            $isSensitive  = $this->sensitiveKey((string) $key);
            $keySanitizer = $isSensitive ? new self() : $this;
            $safeKey      = is_string($key) ? ($keySanitizer->text($key, 255) ?? self::Redacted) : $key;

            if ($isSensitive) {
                $result[$safeKey] = self::Redacted;
            } elseif (is_array($value)) {
                $result[$safeKey] = $depth >= $this->limit('context_depth', 6)
                    ? self::Redacted
                    : $this->sanitizeArray($value, $remaining, $depth + 1);
            } elseif (is_string($value)) {
                $result[$safeKey] = $this->text($value, $this->limit('text_limit', 2000));
            } elseif (is_scalar($value) || $value === null) {
                $result[$safeKey] = is_float($value) && !is_finite($value) ? self::Redacted : $value;
            } else {
                $result[$safeKey] = self::Redacted;
            }
        }

        return $result;
    }

    /** @param array<array-key, mixed> $data */
    private function collectSecrets(array $data, int &$remaining, int $depth = 0, bool $sensitive = false): void
    {
        foreach ($data as $key => $value) {
            if ($remaining-- <= 0 || $depth > 6) {
                return;
            }

            $isSensitive = $sensitive || $this->sensitiveKey((string) $key);

            if (is_array($value)) {
                $this->collectSecrets($value, $remaining, $depth + 1, $isSensitive);
            } elseif ($isSensitive && is_string($value) && $value !== '' && $value !== self::Redacted) {
                $this->secrets[] = $value;
                $this->secrets[] = rawurlencode($value);
                $this->secrets[] = preg_replace('/^(?:Bearer|Basic)\s+/i', '', $value) ?? $value;
            }
        }
    }

    private function truncate(string $value, int $limit): string
    {
        $limit = max(1, $limit);

        return mb_strlen($value) <= $limit ? $value : mb_substr($value, 0, max(0, $limit - 1)) . '…';
    }
}
