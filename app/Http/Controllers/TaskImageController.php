<?php

namespace App\Http\Controllers;

use App\Models\Todolist_task;
// use Illuminate\Support\Facades\Image;
// use Intervention\Image\Facades\Image as Image;
use Image;

class TaskImageController extends Controller
{
    private $thuminbail_prefix = "thumbnail_";
    public function show($task_id, $imgName_Or_thumbPath, $imgName_If_exists = "")
    {
        //// Add validation to get image by user id
        $localPathImg =
            ($imgName_Or_thumbPath = "thumbnails" ?
            $imgName_Or_thumbPath . "/" . $this->thuminbail_prefix . $imgName_If_exists :
            $imgName_Or_thumbPath
        );
        $imgPath = storage_path('app/todoImages/' . $imgName_Or_thumbPath);
        return response()->file($imgPath);
    }

    public static function getImageValidation($task_id, $img_src)
    {
        $task_with_this_id = Todolist_task::find($task_id);
        if ($task_with_this_id->img_src = $img_src) {
            return true;
        }

        return false;
    }

    public function storeImage($image, $curr_user_id, $thumbOrOrig = "thumb")
    {
        // Save image on serve
        $imageFilename = time() . '.' .
        $image->getClientOriginalName();
        $pathNormal = $image->storeAs('todoImages', $imageFilename);
        $pathThumbinal = $this->thuminbail_prefix . $imageFilename;
        $pathCached = $image->path();
        $this->createThumbnail($pathCached, $pathThumbinal, 300, 300);

        // Return image URL
        $pathIfThumb = ($thumbOrOrig = "thumb" ?
            "/thumbnails/" :
            "/"
        );
        return "/task-img/" . $curr_user_id . $pathIfThumb . $imageFilename;
    }

    private function createThumbnail($path, $NameForSave, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(storage_path("app/todoImages/thumbnails"). "/" . $NameForSave);
    }
}
