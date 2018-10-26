<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SceneController extends Controller
{
    //
  public function create() {
    $categories = ["1" => "Baseball Game", "2" => "Travel", "3" => "Dining", "4" => "Accomodations"];
    $filesInFolder = \File::files(public_path('scenery'));     
      $scenery = array();
      $scenery["unassigned"] = "Please Select a Art File";
      foreach($filesInFolder as $path) { 
          $file = pathinfo($path);
          $existingScene = Scene::where('filename', '=', $file['basename'])->count();
          if ($existingScene == 0) {
          $scenery[$file['basename']] = $file['basename'];
         }
      } 

    return view('admin.create_scene', ['categories' => $categories, 'scenery' => $scenery]);
    }  

    public function store(Request $request) {
      $scene = new Scene;
      $scene->title = $request->title;
      $scene->filename = $request->filename;
      $scene->category = $request->category;
      $scene->save();
      return redirect('admin/scenes')->with('success', 'Scene has been added');;
    }


	public function edit($id) {
		$scene = Scene::find($id);
    $categories = ["1" => "Baseball Game", "2" => "Travel", "3" => "Dining", "4" => "Accomodations"];
    $filesInFolder = \File::files(public_path('scenery'));     
      $scenery = array();
      $scenery[$scene->filename] = $scene->filename;
      foreach($filesInFolder as $path) { 
          $file = pathinfo($path);
          $existingScene = Scene::where('filename', '=', $file['basename'])->count();
          if ($existingScene == 0) {
          $scenery[$file['basename']] = $file['basename'];
         }
       }

 		return view('admin.edit_scene', ['scene' => $scene, 'scenery' => $scenery, 'categories' => $categories]);
    }  

    public function update(Request $request, $id) {
    	$scene = Scene::find($id);
    	$scene->title = $request->title;
    	$scene->filename = $request->filename;
    	$scene->category = $request->category;
    	$scene->save();
    	return redirect('admin/scenes')->with('success', 'Scene has been updated');;
    }


	public function destroy($id) {
		$scene = Scene::find($id);
		$scene->delete();
    	return redirect('admin/scenes')->with('success', 'Scene has been removed');;
    }  


	public function index() {
		$scenes = Scene::all();
    $categories = ["1" => "Baseball Game", "2" => "Travel", "3" => "Dining", "4" => "Accomodations"];

 		return view('admin.scenes', ['scenes' => $scenes, 'categories' => $categories]);
    }  


//RETURN SPECIFIC ITEM BASED ON ID
  public function get_json_by_id($id) {
      $scene = Scene::find($id);
      if($scene) {
        return response()->json(["response" => "OK", "scene" => $scene]);
      }
      else {
        return response()->json(["response" => "Scene Unavailable"]);
      }
  }

//RETURN RANDOM ITEM BASED ON CATEGORY
  public function get_json_by_category($category) {
      $scene = Scene::where('category', '=', $category)
                          ->inRandomOrder()->first();
      if($scene) {
        return response()->json(["response" => "OK", "scene" => $scene]);
      }
      else {
        return response()->json(["response" => "No Scenes Found"]);
      }
  }


}