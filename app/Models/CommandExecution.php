<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\Datetime;
use App\Enums\CommandExecutionStatuses;
use App\Support\ArtisanHistoryRedactor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property ?int $user_id
 * @property string $user_name
 * @property ?string $ip_address
 * @property string $command
 * @property string $command_name
 * @property array<int, string>|null $command_arguments
 * @property CommandExecutionStatuses $status
 * @property ?int $exit_code
 * @property ?string $output
 * @property int $duration_ms
 * @property Carbon $executed_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?User $user
 */
class CommandExecution extends BaseModel
{
    /** @use HasFactory<\Database\Factories\CommandExecutionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'command_arguments' => 'array',
            'status'            => CommandExecutionStatuses::class,
            'executed_at'       => Datetime::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return Attribute<string, string> */
    protected function command(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value): string => app(ArtisanHistoryRedactor::class)->redact(is_string($value) ? $value : ''),
            set: static fn (string $value): string => app(ArtisanHistoryRedactor::class)->redact($value),
        );
    }

    /** @return Attribute<string|null, string|null> */
    protected function output(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value): ?string => is_string($value) ? app(ArtisanHistoryRedactor::class)->redact($value) : null,
            set: static fn (?string $value): ?string => $value === null ? null : app(ArtisanHistoryRedactor::class)->redact($value),
        );
    }

    /** @return Attribute<list<string>|null, list<string>|null> */
    protected function commandArguments(): Attribute
    {
        return Attribute::make(
            get: static function (mixed $value): ?array {
                if (!is_string($value)) {
                    return null;
                }

                if (app(ArtisanHistoryRedactor::class)->redact($value) !== $value) {
                    return ['[REDACTED]'];
                }

                $decoded = json_decode($value, true, flags: JSON_THROW_ON_ERROR);

                if (!is_array($decoded)) {
                    return ['[REDACTED]'];
                }

                $arguments = [];

                foreach ($decoded as $argument) {
                    if (!is_string($argument)) {
                        return ['[REDACTED]'];
                    }

                    $arguments[] = $argument;
                }

                return $arguments;
            },
            set: static function (?array $value): ?string {
                if ($value === null) {
                    return null;
                }

                $encoded = json_encode($value, JSON_THROW_ON_ERROR);

                return app(ArtisanHistoryRedactor::class)->redact($encoded) === $encoded
                    ? $encoded
                    : '["[REDACTED]"]';
            },
        );
    }
}
