<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class MainController extends Controller
{
    /**
    * @method: GET
    *
    * @return Render view for uploads images
    */
    public function index() {
    	$images = Image::get();
    	return view('upload',compact('images'));
    }

    /**
    * Method : POST
    *
    * @return Post image and store in database
    */
    public function storeImage(Request $request){
    	if($request->file('file') && $request->file('file')->isValid()){
    		$imageName = str_random(12).$request->file('file')->getClientOriginalExtension();
    		$imageModel = new Image;
    		$imageModel->image = $imageName;
    		$imageModel->caption = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
    		$request->file('file')->move(public_path() . '/uploads', $imageName);
    		if($imageModel->save()){
    			$images = Image::get();
    			$view = view('partials.imagelist', compact('images'))->render();
    			return response()->json(['id'=>$imageModel->id,'html'=>$view]);
    		}else{
    			return response()->json(['message' => 'Error while saving image'],422);
    		}
    	}else{
    		return response()->json(['message' => 'Invalid image'],422);
    	}
    }

    /**
    * Method : GET
    *
    * @return return all images
    */
    public function allImages(){
    	$images = Image::get();
		return view('partials.imagelist', compact('images'))->render();
    }

    /**
    * Method : DELETE
    *
    * @return delete images
    */
    public function deleteImage($id) {
    	$image = Image::findOrFail($id);
        if ($image && count($image) > 0) {

            $file = public_path() . '/uploads/'.$image->image;
            if(is_file($file)){
                @unlink($file);
            }
            $image->delete();
        }
        $images = Image::get();
		$view = view('partials.imagelist', compact('images'))->render();
        return response()->json(['html' => $view]);    
    }
}
