<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'assigned_to');
    }
}
