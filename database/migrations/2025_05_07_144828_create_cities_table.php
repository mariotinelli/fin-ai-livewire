<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('state_id')->constrained();
            $table->string('ibge_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
