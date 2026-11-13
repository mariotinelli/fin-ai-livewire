<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        $conversationsTable = config()->string('ai.conversations.tables.conversations', 'agent_conversations');
        $messagesTable      = config()->string('ai.conversations.tables.messages', 'agent_conversation_messages');

        Schema::table($conversationsTable, function (Blueprint $table): void {
            $table->string('participant_type')->nullable()->after('user_id');
            $table->unsignedBigInteger('participant_id')->nullable()->after('participant_type');
            $table->index(['participant_type', 'participant_id', 'updated_at'], 'agent_conversations_participant_updated_index');
        });

        Schema::table($messagesTable, function (Blueprint $table): void {
            $table->string('participant_type')->nullable()->after('user_id');
            $table->unsignedBigInteger('participant_id')->nullable()->after('participant_type');
            $table->text('approval_state')->nullable()->after('meta');
            $table->index(['conversation_id', 'participant_type', 'participant_id', 'updated_at'], 'agent_messages_participant_conversation_index');
            $table->index(['participant_type', 'participant_id'], 'agent_messages_participant_index');
        });

        $this->backfillParticipants($conversationsTable);
        $this->backfillParticipants($messagesTable);
    }

    public function down(): void
    {
        $conversationsTable = config()->string('ai.conversations.tables.conversations', 'agent_conversations');
        $messagesTable      = config()->string('ai.conversations.tables.messages', 'agent_conversation_messages');

        Schema::table($messagesTable, function (Blueprint $table): void {
            $table->dropIndex('agent_messages_participant_conversation_index');
            $table->dropIndex('agent_messages_participant_index');
            $table->dropColumn(['participant_type', 'participant_id', 'approval_state']);
        });

        Schema::table($conversationsTable, function (Blueprint $table): void {
            $table->dropIndex('agent_conversations_participant_updated_index');
            $table->dropColumn(['participant_type', 'participant_id']);
        });
    }

    private function backfillParticipants(string $table): void
    {
        DB::table($table)
            ->whereNotNull('user_id')
            ->chunkById(500, function (Collection $rows) use ($table): void {
                foreach ($rows as $row) {
                    /** @var object{id: string, user_id: int} $row */
                    DB::table($table)
                        ->where('id', $row->id)
                        ->update([
                            'participant_type' => User::class,
                            'participant_id'   => $row->user_id,
                        ]);
                }
            });
    }
};
