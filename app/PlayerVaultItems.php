<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerVaultItems extends Model
{
    //
    public function player() {
    	return $this->hasOne('App\Player', 'email', 'email');

    }
}
