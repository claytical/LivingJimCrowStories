<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;

class StoryController extends Controller
{
    //
	public function play($id) {

//		$story = Story::find($id);
		$story = new \stdClass();
		$story->title = "Sample Title for Story";
		$story->description = "Lorem ipsum description";
		$story->id = 1;
		$story->authors = "Me, Myself, and I";
		$story->squiffy = "example";
 		return view('story', ['story' => $story]);
    }  

	public function edit($id) {

		$story = Story::find($id);
 		return view('story_edit', ['story' => $story]);
    }  

	public function create() {
 		return view('story_create');
    }  

}