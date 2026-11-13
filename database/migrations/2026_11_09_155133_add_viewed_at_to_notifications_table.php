<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table): void {
            $table->timestamp('viewed_at')->nullable();
            $table->index(['notifiable_type', 'notifiable_id', 'viewed_at'], 'notifications_notifiable_viewed_index');
        });

        DB::table('notifications')->whereNull('viewed_at')->whereNotNull('read_at')->update(['viewed_at' => DB::raw('read_at')]);
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table): void {
            $table->dropIndex('notifications_notifiable_viewed_index');
            $table->dropColumn('viewed_at');
        });
    }
};
