<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Player;

class SocialAuthController extends Controller
{
    //
	public function redirect($service) {
        return Socialite::driver ( $service )->stateless()->redirect ();
    }

	public function callback($service) {
        $user = Socialite::with ( $service )->user ();
        $player_check = Player::where('email', '=', $user->email)->count();
        if( $player_check == 0) {
        	//make a new player
        	$player = new Player;
        	$player->email = $user->email;
        	$player->name = $user->name;
        	$player->save();
        }
        session(['email' => $user->email]);
        return view ( 'authenticated' )->withDetails ( $user )->withService ( $service );
    }    
}
