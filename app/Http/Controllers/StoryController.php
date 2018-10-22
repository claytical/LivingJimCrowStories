<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    //
    public function welcome() {
    	$stories = Story::all();
 		return view('welcome', ['stories' => $stories]);

    }
	public function show($id) {

		$story = Story::find($id);
/*		$story = new \stdClass();
		$story->title = "Sample Title for Story";
		$story->description = "Lorem ipsum description";
		$story->id = 1;
		$story->authors = "Me, Myself, and I";
		$story->squiffy = "example";
 */
 		return view('story', ['story' => $story]);
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
    	return redirect('admin/stories')->with('success', 'Stock has been updated');;
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