<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Exceptions\InvitationPublicationFailed;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use stdClass;
use Throwable;

final readonly class SendUserInvitation
{
    public function handle(User $user): string
    {
        return DB::transaction(function () use ($user): string {
            $user          = User::query()->lockForUpdate()->findOrFail($user->id);
            $previousToken = $this->tokensFor($user)->first();

            return Password::sendResetLink(
                ['email' => $user->email],
                fn (User $recipient, string $token): null => $this->scheduleInvitation($recipient, $token, $previousToken),
            );
        });
    }

    private function scheduleInvitation(User $recipient, string $token, ?stdClass $previousToken): void
    {
        $notification    = new NewUserNotification($token, $recipient->email);
        $replacementHash = $this->tokensFor($recipient)->value('token');

        if (!is_string($replacementHash)) {
            throw new \RuntimeException('Token do convite não foi persistido.');
        }

        DB::afterCommit(fn (): null => $this->publishInvitation($recipient, $notification, $previousToken, $replacementHash));
    }

    private function publishInvitation(User $recipient, NewUserNotification $notification, ?stdClass $previousToken, string $replacementHash): void
    {
        try {
            $recipient->notify($notification);
        } catch (Throwable $throwable) {
            $this->restorePreviousToken($recipient, $previousToken, $replacementHash);

            throw new InvitationPublicationFailed($throwable->getMessage(), previous: $throwable);
        }
    }

    private function restorePreviousToken(User $recipient, ?stdClass $previousToken, string $replacementHash): void
    {
        DB::transaction(function () use ($recipient, $previousToken, $replacementHash): void {
            User::withTrashed()->lockForUpdate()->find($recipient->id);
            $tokens = $this->tokensFor($recipient);

            if ($tokens->lockForUpdate()->value('token') !== $replacementHash) {
                return;
            }

            $tokens->delete();

            if ($previousToken instanceof stdClass) {
                $tokens->insert((array) $previousToken);
            }
        });
    }

    private function tokensFor(User $recipient): Builder
    {
        $table = config()->string('auth.passwords.' . Password::getDefaultDriver() . '.table');

        return DB::table($table)->where('email', $recipient->email);
    }
}
