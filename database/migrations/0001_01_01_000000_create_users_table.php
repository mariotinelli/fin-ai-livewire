<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS citext');
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent');

        DB::statement(<<<'SQL'
            CREATE COLLATION IF NOT EXISTS app_ai_ci (
                provider = icu,
                locale = 'und-u-ks-level1',
                deterministic = false
            )
            SQL);

        $hasExpectedCollation = (bool) DB::scalar(<<<'SQL'
            SELECT EXISTS (
                SELECT 1
                FROM pg_collation AS definition
                INNER JOIN pg_namespace AS namespace ON namespace.oid = definition.collnamespace
                WHERE namespace.nspname = current_schema()
                    AND definition.collname = 'app_ai_ci'
                    AND definition.collprovider = 'i'
                    AND COALESCE(to_jsonb(definition)->>'colliculocale', to_jsonb(definition)->>'colllocale') = 'und-u-ks-level1'
                    AND definition.collisdeterministic = false
            )
            SQL);

        if (!$hasExpectedCollation) {
            throw new RuntimeException('A collation app_ai_ci existente possui uma definição incompatível.');
        }

        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->rawColumn('name', 'citext')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->rawColumn('name', 'citext')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table): void {
            $table->foreignId('permission_id')->constrained();
            $table->foreignId('role_id')->constrained();
        });

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->collation('app_ai_ci');
            $table->unsignedTinyInteger('type');
            $table->foreignId('role_id')->nullable()->constrained();
            $table->rawColumn('email', 'citext')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('invitation_pending')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        DB::statement('DROP COLLATION app_ai_ci');
    }
};
