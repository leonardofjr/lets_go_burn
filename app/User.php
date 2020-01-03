<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the users' geopoint.
     */
        public function geopoints()
        {
            return $this->belongsToMany('App\Geopoint', 'geopoint_user');
        }

        public function isOnline() {
            return Cache::has('user-is-online-' . $this->id);
        }

        public function roles() {
            return $this->belongsToMany('App\Role', 'role_user');
        }
}
