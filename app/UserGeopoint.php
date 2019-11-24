<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGeopoint extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lat', 'lng',
    ];

    /**
     * Get the geopoint record associated with the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
