<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::transaction(function (): void {
            $duplicates = DB::table('permission_role')
                ->select('permission_id', 'role_id')
                ->groupBy('permission_id', 'role_id')
                ->havingRaw('COUNT(*) > 1')
                ->get();

            foreach ($duplicates as $duplicate) {
                $pair = DB::table('permission_role')
                    ->where('permission_id', $duplicate->permission_id)
                    ->where('role_id', $duplicate->role_id);

                $count = count((clone $pair)->lockForUpdate()->get());

                if ($count > 1) {
                    $pair->limit($count - 1)->delete();
                }
            }
        });

        Schema::table('permission_role', function (Blueprint $table): void {
            $table->unique(['permission_id', 'role_id']);
        });
    }

    public function down(): void
    {
        if (!Schema::hasIndex('permission_role', ['permission_id'])) {
            Schema::table('permission_role', function (Blueprint $table): void {
                $table->index('permission_id');
            });
        }

        Schema::table('permission_role', function (Blueprint $table): void {
            $table->dropUnique(['permission_id', 'role_id']);
        });
    }
};
