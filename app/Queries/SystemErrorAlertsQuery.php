<?php

declare(strict_types = 1);

namespace App\Queries;

use App\Enums\SortDirection;
use App\Models\SystemErrorAlert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class SystemErrorAlertsQuery
{
    /** @return LengthAwarePaginator<int, SystemErrorAlert> */
    public function paginate(
        string $search = '',
        ?int $status = null,
        ?int $severity = null,
        ?string $environment = null,
        string $sortBy = 'last_seen_at',
        string $sortDirection = 'desc',
        int $perPage = 10,
        ?int $page = null,
    ): LengthAwarePaginator {
        return SystemErrorAlert::query()
            ->with('user')
            ->select([
                'id',
                'status',
                'severity',
                'environment',
                'exception_class',
                'message',
                'request_method',
                'request_url',
                'user_id',
                'occurrences',
                'last_seen_at',
                'created_at',
            ])
            ->when($status !== null, fn (Builder $query) => $query->where('status', $status))
            ->when($severity !== null, fn (Builder $query) => $query->where('severity', $severity))
            ->when($environment !== null, fn (Builder $query) => $query->where('environment', $environment))
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery->whereInsensitive('exception_class', $search)
                        ->orWhereInsensitive('message', $search)
                        ->orWhereInsensitive('request_url', $search);
                });
            })
            ->orderBy($sortBy, SortDirection::from($sortDirection)->value)
            ->paginate(perPage: $perPage, page: $page);
    }

    /** @return array<int|string, string> */
    public function environments(): array
    {
        $environments = SystemErrorAlert::query()
            ->select('environment')
            ->distinct()
            ->orderBy('environment')
            ->pluck('environment', 'environment')
            ->all();

        return array_filter($environments, is_string(...));
    }
}
