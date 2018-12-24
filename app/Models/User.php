<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Posts;

class User extends Authenticatable
{
    use Notifiable; 
    use \Spatie\Permission\Traits\HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function revokeRoles($roles)
    {
        foreach($roles as $role) {
            $this->removeRole($role->name);
        }
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
