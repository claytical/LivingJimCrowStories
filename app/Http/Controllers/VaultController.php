<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VaultItem;
use Illuminate\Support\Facades\Storage;
use App\Player;
use App\PlayerVaultItems;
use Socialite;
use Illuminate\Support\Facades\Auth;

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
    $icons = ["1" => "video.png", "2" => "image.png", "3" => "audio.png", "4" => "article.png", "5" => "greenbook.png", "6" => "video.png", "7" => "printmedia.png", "8" => "unlock.png"];

 		return view('admin.vault', ['items' => $items, 'categories' => $categories, 'icons' => $icons]);
    }  

  public function my_vault() {
    $user = Auth::user();
    $vault = $user->items;
    $locked_items = VaultItem::whereNotIn('vault_items.id', $vault)->get();
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Web Article", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping", "8" => "Bookmark"];
    $icons = ["1" => "video.png", "2" => "image.png", "3" => "audio.png", "4" => "article.png", "5" => "greenbook.png", "6" => "video.png", "7" => "printmedia.png", "8" => "unlock.png"];

    return view('vault', ['vault' => $vault, 'locked' => $locked_items, 'categories' => $categories, 'icons' => $icons]);
  }

//RETURN SPECIFIC ITEM BASED ON ID
  public function get_json_by_id($id) {
      $item = VaultItem::find($id);
      $user = Auth::user();
      
      if($user) {
        $items = $user->items();        
        if($items->where('vault_item_id', '=', $id)->count() == 0) {
          //new item
            $player_vault_item = new PlayerVaultItems;
            $player_vault_item->user_id = $user->id;
            $player_vault_item->vault_item_id = $id;
            $player_vault_item->save();
            return response()->json(["response" => "New Item", "item" => $item]);

        }
        else {
          //exists
            return response()->json(["response" => "Existing Item", "item" => $item]);
        }
      }
      else {
            return response()->json(["response" => "Not Saved", "item" => $item]);
      }

  }

//RETURN RANDOM ITEM BASED ON CATEGORY
  public function get_json_random_item_by_category($category) {
      $user = Auth::user();
      $user_items = $user->items()->pluck('vault_item_id');
      $item = VaultItem::where('category', '=', $category)
                          ->whereNotIn('vault_items.id', $user_items)
                          ->inRandomOrder()->first();
      if($item) {
        $player_vault_item = new PlayerVaultItems;
        $player_vault_item->user_id = $user->id;
        $player_vault_item->vault_item_id = $id;
        $player_vault_item->save();
        return response()->json(["response" => "New Item", "item" => $item]);
      }
      else {
        return response()->json(["response" => "No New Items"]);
      }
  }


}