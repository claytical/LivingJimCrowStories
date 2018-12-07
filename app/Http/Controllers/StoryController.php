<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use Illuminate\Support\Facades\Storage;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\VaultItem;

class StoryController extends Controller
{
    //
    public function welcome() {
    	$stories = Story::all();
 		return view('welcome', ['stories' => $stories]);

    }
	public function show($id) {

		$story = Story::find($id);
    $user = Auth::user();
    if($user) {
    $vault = $user->items->groupBy('category');
    $vault->transform(function ($item, $key) {
      return $item['locked'] = false; 
    });
    $locked_items = VaultItem::whereNotIn('vault_items.id', $vault)->groupBy('category')->get();
    $locked_items->transform(function($item, $key) {
      return $item['locked'] = true;
    });

    $categories = ["1" => "Archival Video", "2" => "Archival Photo", "3" => "Archival Audio", "4" => "Web Article", "5" => "Scholarly Article", "6" => "Bonus Footage", "7" => "Newspaper Clipping", "8" => "Bookmark"];
    $icons = ["1" => "video.png", "2" => "image.png", "3" => "audio.png", "4" => "article.png", "5" => "greenbook.png", "6" => "video.png", "7" => "printmedia.png", "8" => "unlock.png"];

      return view('story', ['story' => $story, 'vault' => $vault, 'categories' => $categories, 'icons' => $icons, 'locked' => $locked_items]);

    }
    else {

      return view('story', ['story' => $story, 'vault' => false, 'locked' => false]);

    }    
  }  

	public function edit($id) {
		$story = Story::find($id);
		$filesInFolder = \File::files(public_path('js/stories'));     
    	$squiffies = array();
    	$squiffies[$story->squiffy] = $story->squiffy;
    	foreach($filesInFolder as $path) { 
          $file = pathinfo($path);
          $existingSquiffy = Story::where('squiffy', '=', $file['filename'])->count();
          if ($existingSquiffy == 0) {
    	  	$squiffies[$file['filename']] = $file['filename'];
     	   }
     	} 

 		return view('admin.edit_story', ['story' => $story, 'squiffies' => $squiffies]);
    }  

    public function update(Request $request, $id) {
    	$story = Story::find($id);
    	$story->title = $request->title;
    	$story->authors = $request->authors;
    	$story->description = $request->description;
    	$story->squiffy = $request->squiffy;
    	$story->save();
    	return redirect('admin/stories')->with('success', 'Story has been updated');;
    }
	public function create() {
		$filesInFolder = \File::files(public_path('js/stories'));     
    	$squiffies = array();
    	$squiffies["unassigned"] = "Please Select a Squiffy File";
    	foreach($filesInFolder as $path) { 
          $file = pathinfo($path);
          $existingSquiffy = Story::where('squiffy', '=', $file['filename'])->count();
          if ($existingSquiffy == 0) {
    	  	$squiffies[$file['filename']] = $file['filename'];
     	   }
     	} 
 		return view('admin.create_story', ['squiffies' => $squiffies]);
    }  

    public function store(Request $request) {
    	$story = new Story;
    	$story->title = $request->title;
    	$story->authors = $request->authors;
    	$story->description = $request->description;
    	$story->squiffy = $request->squiffy;
    	$story->save();
    	return redirect('admin/stories')->with('success', 'Story has been added');;
    }

	public function destroy($id) {
		$story = Story::find($id);
		$story->delete();
    	return redirect('admin/stories')->with('success', 'Story has been removed');;
    }  


	public function admin() {
		$stories = Story::all();
 		return view('admin.stories', ['stories' => $stories]);
    }  

}