<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function testStudioDatabase()
    {

        // Create three App\User instances...
        $studio = factory(Studio::class, 3)->create();
    
        // Use model in tests...
    }
}
