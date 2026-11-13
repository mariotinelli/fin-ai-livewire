<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\AuditableObserver;

class PermissionSeeder extends Seeder
{
    public function run(AuditableObserver $auditor): void
    {
        DB::transaction(function () use ($auditor): void {
            $catalogue = Can::allCases();
            $existing  = Permission::query()
                ->whereIn('name', array_column($catalogue, 'value'))
                ->lockForUpdate()
                ->get()
                ->keyBy(fn (Permission $permission): string => strtolower($permission->name));
            $rows    = [];
            $changed = [];

            foreach ($catalogue as $entry) {
                $permission = $existing->get(strtolower($entry->value)) ?? new Permission();

                if (!$permission->exists) {
                    $permission->name = $entry->value;
                }

                $permission->description = $entry->description();

                if (!$permission->isDirty()) {
                    continue;
                }

                $permission->updateTimestamps();
                $rows[] = [
                    'name'        => $permission->name,
                    'description' => $permission->description,
                    'created_at'  => $permission->getAttributes()['created_at'],
                    'updated_at'  => $permission->getAttributes()['updated_at'],
                ];
                $changed[] = $permission;
            }

            if ($rows === []) {
                return;
            }

            Permission::query()->upsert($rows, ['name'], ['description', 'updated_at']);
            $ids = Permission::query()->whereIn('name', array_column($rows, 'name'))->pluck('id', 'name');

            /** Upserts bypass model events; retain the original snapshots for the configured audit transport. */
            foreach ($changed as $permission) {
                if ($permission->exists) {
                    $auditor->updated($permission);
                } else {
                    $id = $ids->get($permission->name);

                    if (!is_numeric($id)) {
                        throw new \RuntimeException('Permissão não persistida.');
                    }

                    $permission->id     = (int) $id;
                    $permission->exists = true;
                    $auditor->created($permission);
                }
            }
        });
    }
}
