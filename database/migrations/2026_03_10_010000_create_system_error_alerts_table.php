<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('system_error_alerts', function (Blueprint $table): void {
            $table->id();
            $table->string('fingerprint');
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('severity');
            $table->string('environment');
            $table->string('exception_class');
            $table->text('message');
            $table->string('file')->nullable();
            $table->unsignedInteger('line')->nullable();
            $table->string('route_name')->nullable();
            $table->string('request_method', 10)->nullable();
            $table->text('request_url')->nullable();
            $table->string('request_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('context')->nullable();
            $table->longText('trace')->nullable();
            $table->unsignedInteger('occurrences')->default(1);
            $table->timestamp('first_seen_at');
            $table->timestamp('last_seen_at');
            $table->timestamp('last_notified_at')->nullable();
            $table->timestamps();

            $table->index(['fingerprint', 'environment']);
            $table->index(['status', 'severity']);
            $table->index(['environment', 'last_seen_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_error_alerts');
    }
};
