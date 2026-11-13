<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\Datetime;
use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $fingerprint
 * @property SystemErrorAlertStatuses $status
 * @property SystemErrorAlertSeverities $severity
 * @property string $environment
 * @property string $exception_class
 * @property string $message
 * @property ?string $file
 * @property ?int $line
 * @property ?string $route_name
 * @property ?string $request_method
 * @property ?string $request_url
 * @property ?string $request_id
 * @property ?int $user_id
 * @property array<string, mixed>|null $context
 * @property array<int, array{attributes: array<string, mixed>, audit_ids: array<int, int>}>|null $consolidated_history
 * @property ?string $trace
 * @property int $occurrences
 * @property ?Carbon $first_seen_at
 * @property ?Carbon $last_seen_at
 * @property ?Carbon $last_notified_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?User $user
 */
class SystemErrorAlert extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SystemErrorAlertFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status'               => SystemErrorAlertStatuses::class,
            'severity'             => SystemErrorAlertSeverities::class,
            'context'              => 'array',
            'consolidated_history' => 'array',
            'first_seen_at'        => Datetime::class,
            'last_seen_at'         => Datetime::class,
            'last_notified_at'     => Datetime::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
