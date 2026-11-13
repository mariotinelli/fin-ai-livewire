<?php

declare(strict_types = 1);

use App\Models\SystemErrorAlert;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasIndex('system_error_alerts', ['fingerprint', 'environment'], 'unique')) {
            return;
        }

        if (!Schema::hasColumn('system_error_alerts', 'consolidated_history')) {
            Schema::table('system_error_alerts', function (Blueprint $table): void {
                $table->json('consolidated_history')->nullable();
            });
        }

        Schema::table('system_error_alerts', function (Blueprint $table): void {
            $table->unsignedBigInteger('occurrences')->default(1)->change();
        });

        DB::transaction(function (): void {
            $groups = DB::table('system_error_alerts')
                ->select(['fingerprint', 'environment'])
                ->groupBy('fingerprint', 'environment')
                ->havingRaw('COUNT(*) > 1')
                ->get();

            foreach ($groups as $group) {
                $rows = DB::table('system_error_alerts')
                    ->where('fingerprint', $group->fingerprint)
                    ->where('environment', $group->environment)
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->get();
                $canonicalId = $rows->min('id');
                $latest      = $rows->sortByDesc('last_seen_at')->firstOrFail();
                $ids         = $rows->pluck('id')->all();
                $history     = [];

                foreach ($rows as $row) {
                    $history[] = [
                        'attributes' => (array) $row,
                        'audit_ids'  => DB::table('audits')
                            ->where('auditable_type', SystemErrorAlert::class)
                            ->where('auditable_id', $row->id)
                            ->orderBy('id')
                            ->pluck('id')
                            ->all(),
                    ];
                }

                /** @var array<string, mixed> $attributes */
                $attributes = (array) $latest;
                unset($attributes['id']);

                DB::table('system_error_alerts')->where('id', $canonicalId)->update([
                    ...$attributes,
                    'status'               => $rows->min('status'),
                    'occurrences'          => $rows->sum('occurrences'),
                    'first_seen_at'        => $rows->min('first_seen_at'),
                    'last_seen_at'         => $rows->max('last_seen_at'),
                    'last_notified_at'     => $rows->max('last_notified_at'),
                    'created_at'           => $rows->min('created_at'),
                    'updated_at'           => $rows->max('updated_at'),
                    'consolidated_history' => json_encode($history, JSON_THROW_ON_ERROR),
                ]);

                DB::table('audits')
                    ->where('auditable_type', SystemErrorAlert::class)
                    ->whereIn('auditable_id', $ids)
                    ->update(['auditable_id' => $canonicalId]);

                DB::table('system_error_alerts')
                    ->whereIn('id', $ids)
                    ->where('id', '<>', $canonicalId)
                    ->delete();
            }
        });

        Schema::table('system_error_alerts', function (Blueprint $table): void {
            $table->unique(['fingerprint', 'environment']);
            $table->dropIndex(['fingerprint', 'environment']);
        });
    }

    public function down(): void
    {
        Schema::table('system_error_alerts', function (Blueprint $table): void {
            $table->index(['fingerprint', 'environment']);
            $table->dropUnique(['fingerprint', 'environment']);
        });
    }
};
