<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_users';

    public $timestamps = false;

    /**
     * The attributes that should be mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password_users',
        'foto_profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_users',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_users' => 'hashed',
        ];
    }

    /**
     * Overwrite password column for Laravel Authentication.
     */
    public function getAuthPassword()
    {
        return $this->password_users;
    }
}
