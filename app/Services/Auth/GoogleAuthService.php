<?php

namespace App\Services\Auth;

use App\Exceptions\AccountDisabledException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as GoogleUser;

class GoogleAuthService
{
    public function findOrCreateUser(GoogleUser $googleUser): User
    {
        return DB::transaction(function () use ($googleUser): User {
            $email = $googleUser->getEmail();

            if ($email === null) {
                throw new \RuntimeException('Google did not return a verified email address.');
            }

            /** @var User|null $user */
            $user = User::query()
                ->where('email', $email)
                ->orWhere('provider_id', $googleUser->getId())
                ->orWhere('google_id', $googleUser->getId())
                ->lockForUpdate()
                ->first();

            if ($user !== null) {
                if ($user->status !== 'active') {
                    throw new AccountDisabledException;
                }

                $user->forceFill([
                    'google_id' => $user->google_id ?: $googleUser->getId(),
                    'provider' => 'google',
                    'provider_id' => $user->provider_id ?: $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?: now(),
                    'last_login_at' => now(),
                ])->save();

                return $user->refresh();
            }

            return User::query()->create([
                'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: str($email)->before('@')->headline(),
                'email' => $email,
                'password' => null,
                'google_id' => $googleUser->getId(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'status' => 'active',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);
        });
    }
}
