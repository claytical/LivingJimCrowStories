<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerVaultItems extends Pivot
{
    //
    protected $table = 'player_vault_items';
	public function user()
	{
	    return $this->belongsTo('App\User');
	}


    public function item()
    {
        return $this->belongsTo('App\VaultItem');
    }

}
