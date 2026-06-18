<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AppwriteUserProvider implements UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     */
    public function retrieveById($identifier)
    {
        return Admin::find($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     */
    public function retrieveByToken($identifier, $token)
    {
        return Admin::where('remember_token', $token)->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->remember_token = $token;
        $user->save();
    }

    /**
     * Retrieve a user by the given credentials.
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return null;
        }

        $query = Admin::query();

        foreach ($credentials as $key => $value) {
            if (str_contains($key, 'password')) {
                continue;
            }
            $query->where($key, $value);
        }

        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];
        $hash = $user->getAuthPassword();

        if (empty($hash)) {
            return false;
        }

        // If it's a bcrypt hash
        if (str_starts_with($hash, '$2y$') || str_starts_with($hash, '$2a$')) {
            try {
                return Hash::check($plain, $hash);
            } catch (\Exception $e) {
                return false;
            }
        }

        // Fallback for plain text password comparison
        return $plain === $hash;
    }

    /**
     * Rehash the user's password if required and supported.
     */
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // No-op for Appwrite
    }

    /**
     * Revalidate a user against the given credentials.
     */
    public function revalidateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->validateCredentials($user, $credentials);
    }
}
