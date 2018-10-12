<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    public function vault_items() {
		return $this->hasMany('App\PlayerVaultItems', 'email', 'email');
    }
}
