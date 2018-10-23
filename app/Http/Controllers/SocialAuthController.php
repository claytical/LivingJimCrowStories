<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Player;
use App\SocialAccountService;

class SocialAuthController extends Controller
{
    //
	public function redirect($service) {
        return Socialite::driver ( $service )->stateless(true)->redirect ();
    }

	public function callback(SocialAccountService $accountService, $service) {

        try {
            $user = Socialite::with($service)->user();
        }
        catch (\Exception $e) {
            return redirect('/')->with('success', $e->getMessage());;
        }

        $authUser = $accountService->findOrCreate($user, $service);
        auth()->login($authUser, true);

        return redirect()->to('/')->with('success', "Successful Social Login");
//        return view ( 'authenticated' )->withDetails ( $authUser )->withService ( $service );
/*        

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
  */
    }    
}
