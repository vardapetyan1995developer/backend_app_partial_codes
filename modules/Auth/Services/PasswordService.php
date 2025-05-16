<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;

final class PasswordService
{
    public function sendResetLink(string $email): bool
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            return false;
        }

        Event::dispatch('auth.password_reset_link_sent', $email);

        return true;
    }

    public function resetPassword(string $email, string $token, string $password): bool
    {
        $status = Password::reset(compact('email', 'token', 'password'), static function (User $user, string $password): void {
            $user->update(['password' => Hash::make($password)]);

            Event::dispatch('auth.password_reset', $user->id);
        });

        return $status === Password::PASSWORD_RESET;
    }

    public function updatePassword(string $password): void
    {
        DB::transaction(static function () use ($password): void {
            User::query()
                ->where('id', Auth::id())
                ->firstOrFail()
                ->update(['password' => Hash::make($password)]);

            Event::dispatch('auth.password_updated', Auth::id());
        });
    }
}
