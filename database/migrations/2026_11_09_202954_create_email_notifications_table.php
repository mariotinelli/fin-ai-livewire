<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('email_notifications', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('notification_id')->index();
            $table->string('notification_type');
            $table->string('environment', 64);
            $table->string('connection', 64)->nullable();
            $table->string('queue')->nullable();
            $table->unsignedInteger('attempt_count')->default(0);
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('skipped_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('last_failed_at')->nullable();
            $table->string('last_failure_type')->nullable();
            $table->timestamp('completed_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_notifications');
    }
};
