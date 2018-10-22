<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VaultItem;
use Illuminate\Support\Facades\Storage;

class VaultController extends Controller
{
    //
  public function create() {
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Website", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping"];
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
    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Website", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping"];
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
 		return view('admin.vault', ['items' => $items]);
    }  

}