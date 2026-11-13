<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('command_executions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name');
            $table->string('ip_address', 45)->nullable();
            $table->string('command', 500);
            $table->string('command_name');
            $table->json('command_arguments')->nullable();
            $table->unsignedTinyInteger('status');
            $table->unsignedSmallInteger('exit_code')->nullable();
            $table->longText('output')->nullable();
            $table->unsignedInteger('duration_ms');
            $table->timestamp('executed_at');
            $table->timestamps();

            $table->index(['status', 'executed_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('command_executions');
    }
};
