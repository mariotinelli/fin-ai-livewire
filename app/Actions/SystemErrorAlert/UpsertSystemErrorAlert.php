<?php

declare(strict_types = 1);

namespace App\Actions\SystemErrorAlert;

use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

final readonly class UpsertSystemErrorAlert
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function handle(array $attributes): SystemErrorAlert
    {
        $occurredAt = $attributes['occurred_at'];

        if (!$occurredAt instanceof \DateTimeInterface) {
            throw new \InvalidArgumentException('Data de ocorrência inválida.');
        }

        $occurredAt = Carbon::instance($occurredAt);
        $details    = array_intersect_key($attributes, array_flip([
            'severity', 'exception_class', 'message', 'file', 'line', 'route_name',
            'request_method', 'request_url', 'request_id', 'user_id', 'context', 'trace',
        ]));

        return DB::transaction(function () use ($attributes, $occurredAt, $details): SystemErrorAlert {
            $alert = SystemErrorAlert::query()->lockForUpdate()->createOrFirst(
                attributes: [
                    'fingerprint' => $attributes['fingerprint'],
                    'environment' => $attributes['environment'],
                ],
                values: [
                    ...$details,
                    'status'        => SystemErrorAlertStatuses::Open,
                    'occurrences'   => 1,
                    'first_seen_at' => $occurredAt,
                    'last_seen_at'  => $occurredAt,
                ],
            );

            if ($alert->wasRecentlyCreated) {
                return $alert;
            }

            if ($alert->last_seen_at === null || $occurredAt->greaterThanOrEqualTo($alert->last_seen_at)) {
                $alert->fill($details);
                $alert->last_seen_at = $occurredAt;
            }

            if ($occurredAt->lessThan($alert->first_seen_at)) {
                $alert->first_seen_at = $occurredAt;
            }

            if ($alert->status === SystemErrorAlertStatuses::Resolved) {
                $alert->status = SystemErrorAlertStatuses::Open;
            }

            $alert->save();
            $alert->increment('occurrences');

            return $alert->refresh();
        }, attempts: 5);
    }
}
