<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaultItem extends Model
{
    //
	public $timestamps = false;
    
    public function users()
    {
        return $this->belongsToMany('App\User')->using('App\PlayerVaultItems');
    }
}
