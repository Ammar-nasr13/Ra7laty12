<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends AppwriteModel implements AuthenticatableContract
{
    use Authenticatable, Notifiable;

    protected string $collectionName = 'admins';

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
}
