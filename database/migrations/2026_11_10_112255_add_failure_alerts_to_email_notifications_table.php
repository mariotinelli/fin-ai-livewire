<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('email_notifications', function (Blueprint $table): void {
            $table->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('notified_at')->nullable();
            $table->timestamp('discord_notified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('email_notifications', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('requester_id');
            $table->dropColumn(['notified_at', 'discord_notified_at']);
        });
    }
};
