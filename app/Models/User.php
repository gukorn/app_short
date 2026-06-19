<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Master\Location;
use App\Models\Master\UserRole;
use App\Models\Master\Warehouse;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseModel implements AuthenticatableContract
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status',
        'username',
        'email',
        'password',
        'is_admin',
        'firstname',
        'lastname',
        'tel',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
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
            'password' => 'hashed',
        ];
    }

    public function fullname()
    {
        return $this->firstname . " " . $this->lastname;
    }



    public function hasRole($role)
    {
        if (empty($role)) return true;
        $role = strpos($role, "|") ? explode('|', $role) : array($role);
        foreach ($role as $value) {
            if ((!empty($value) && $this->is_admin == 1) || config('app.mode_test') == true)
                return true;
        }
        return false;
    }



}
