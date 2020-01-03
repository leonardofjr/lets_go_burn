<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geopoint extends Model
{
    protected $fillable = [
        'lat', 'lng', 
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
