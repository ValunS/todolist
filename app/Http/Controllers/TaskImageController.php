<?php

namespace App\Http\Controllers;

use App\Models\Todolist_task;
use Illuminate\Support\Facades\Auth;
use Image;

class TaskImageController extends Controller
{
    private $thuminbail_prefix = "thumbnail_";

    public function show($task_id, $imgName_Or_thumbPath, $imgName_If_thumbnal = "")
    {
        $imgName_Or_thumbPath = rtrim($imgName_Or_thumbPath, "/"); //remove "/" if it on end of name
        //// Add validation to get image by user id
        if (!$this->getImageValidation($task_id, $_SERVER['REQUEST_URI'])) {
            abort(403);
        };

        $localPathImg = (
            $imgName_Or_thumbPath == "thumbnails" ?
            $imgName_Or_thumbPath . "/" . $imgName_If_thumbnal :
            $imgName_Or_thumbPath
        );
        $imgPath = storage_path('app/todoImages/') . $localPathImg;
        return response()->file($imgPath);
    }

    public static function getImageValidation($task_id, $img_src)
    {
        if ($task_with_this_id = Todolist_task::find($task_id)) { //if current user have task --> true
            if ($task_with_this_id->user_id == Auth::user()->id) {
                return true;
            }
        };

        return false;
    }

    public function storeImage($curr_task_id, $image, $thumb_Or_orig = "orig")
    {
        // Save image on serve
        $imageFilename = time() . '.' .
        $image->getClientOriginalName();
        $pathNormal = $image->storeAs('todoImages', $imageFilename);

        //create Thumbinal
        $pathThumbinal = $this->thuminbail_prefix . $imageFilename;
        $pathCached = $image->path();
        $this->createThumbnail($pathCached, $pathThumbinal, 300, 300);

        // Return image URL
        $pathIfThumb = ($thumb_Or_orig = "thumb" ?
            "/thumbnails/" :
            "/"
        );
        return "/task-img/" . $curr_task_id . "/" . $imageFilename;
    }

    private function createThumbnail($path, $name_for_save, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(storage_path("app/todoImages/thumbnails") . "/" . $name_for_save);
    }
}
