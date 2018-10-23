<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VaultItem;
use Illuminate\Support\Facades\Storage;
use App\Player;
use App\PlayerVaultItems;

class VaultController extends Controller
{
    //
  public function create() {
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Web Article", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping", "8" => "Bookmark"];
    return view('admin.create_item', ['categories' => $categories]);
    }  

    public function store(Request $request) {
      $item = new VaultItem;
      $item->title = $request->title;
      $item->description = $request->description;
      $item->url = $request->url;
      $item->category = $request->category;
      $item->save();
      return redirect('admin/vault')->with('success', 'Item has been added');;
    }


	public function edit($id) {
		$item = VaultItem::find($id);
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Web Article", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping", "8" => "Bookmark"];
 		return view('admin.edit_item', ['item' => $item, 'categories' => $categories]);
    }  

    public function update(Request $request, $id) {
    	$item = VaultItem::find($id);
    	$item->title = $request->title;
    	$item->url = $request->url;
    	$item->description = $request->description;
    	$item->category = $request->category;
    	$item->save();
    	return redirect('admin/vault')->with('success', 'Item has been updated');;
    }


	public function destroy($id) {
		$item = VaultItem::find($id);
		$item->delete();
    	return redirect('admin/vault')->with('success', 'Item has been removed');;
    }  


	public function index() {
		$items = VaultItem::all();
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Web Article", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping", "8" => "Bookmark"];

 		return view('admin.vault', ['items' => $items, 'categories' => $categories]);
    }  

  public function get_json_by_id($id, $add_to_vault) {

      if(session()->has('email')) {
        $item = VaultItem::find($id);
        $email = session('email');
        $user = Socialite::driver('facebook')->user();
        if($add_to_vault) {
          $existing_item_count = PlayerVaultItems::where('email', '=', $email)->where('vault_item_id', '=', $id)->count();
          if($existing_item_count == 0) {
            $player_vault_item = new PlayerVaultItems;
            $player_vault_items->email = $email;
            $player_vault_items->vault_item_id = $id;
            $player_vault_items->save();
            return response()->json(["response" => "New Item Unlocked!", "item" => $item]);

          }
          else {
            //item already in vault
            return response()->json(["response" => "You have already unlocked this item!", "item" => $item]);

          }
        }
        
      }
      else {
        return response()->json(["response" => "You are not authenticated with a social network and therefore cannot save items to your vault."]);
      }
  }

  public function get_json_by_category($id) {
      $items = VaultItem::where('category', '=', $id)->get();
      return response()->json($item);
  }


}