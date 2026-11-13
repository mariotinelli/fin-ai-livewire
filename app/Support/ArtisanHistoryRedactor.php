<?php

declare(strict_types = 1);

namespace App\Support;

use Illuminate\Support\Arr;

class ArtisanHistoryRedactor
{
    public function limit(): int
    {
        $limit = config('artisan-executor.max_output_bytes', 65536);

        return is_int($limit) && $limit > 0 ? max(128, min($limit, 1048576)) : 65536;
    }

    public function redact(string $value): string
    {
        if (strlen($value) > $this->limit()) {
            return '[Saída omitida: limite excedido.]';
        }

        $value = preg_replace('/-----BEGIN [^-]*PRIVATE KEY-----.*?(?:-----END [^-]*PRIVATE KEY-----|$)/s', '[REDACTED]', $value) ?? '[REDACTED]';
        $value = preg_replace('/["\']?(?:password|passwd|secret|token|api[_-]?key|app[_-]?key|authorization|credential|senha|private[_-]?key)["\']?\s*[:=]\s*(?:"(?:\\\\.|[^"\\\\])*"|\'(?:\\\\.|[^\'\\\\])*\')/is', '[REDACTED]', $value) ?? '[REDACTED]';
        $value = preg_replace('/[^\r\n]*(?:password|passwd|secret|token|api[_-]?key|app[_-]?key|authorization|credential|senha|private[_-]?key)[^\r\n]*/i', '[REDACTED]', $value) ?? '[REDACTED]';
        $value = preg_replace('~[a-z][a-z0-9+.-]*://[^\s/@]+:[^\s/@]+@[^\s]*~i', '[REDACTED]', $value) ?? '[REDACTED]';

        $configuration = Arr::only(config()->all(), ['app', 'database', 'mail', 'services', 'filesystems', 'broadcasting', 'ai']);

        foreach (Arr::dot($configuration) as $key => $secret) {
            if (is_string($secret) && $secret !== '' && preg_match('/(?:^|[._])(?:password|secret|token|key|credentials?)(?:$|\.\d+$)/i', (string) $key) === 1) {
                $value = str_replace($secret, '[REDACTED]', $value);
            }
        }

        return strlen($value) > $this->limit() ? '[Saída omitida: limite excedido.]' : $value;
    }
}
