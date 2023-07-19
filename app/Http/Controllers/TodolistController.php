<?php

namespace App\Http\Controllers;

use App\Models\Todolist_task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;

class TodolistController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $tasks = $this->getTasks(Auth::user()->id);
            return view("todolist.index", ["tasks" => $tasks]);
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
    }

    public function show()
    {
        if (Auth::check()) {
            $tasks = $this->getTasks(Auth::user()->id);
            return response()->json($tasks);
        };
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
    }

    public function store(Request $request)
    {

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $format = $request->input('format');

        //     // Сохраняем изображение на сервере
        //     $path = $image->store('images');

        //     // Возвращаем URL изображения и формат клиенту
        //     return response()->json([
        //         'image_url' => asset($path),
        //         'format' => $format,
        //     ]);
        // }

        // return response()->json([
        //     'message' => 'Изображение не найдено.',
        // ], 400);

        // $jsonForReturn = [];
        //         $jsonForReturn = $request->file('image');
        // return response()->json($jsonForReturn);

        if (Auth::check()) {
            Todolist_task::create([
                "title" => $request->title,
                "full_text" => $request->full_text,
                "completed" => 0,
                "user_id" => Auth::user()->id,
            ]);
            return "Success added task";
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');

    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $format = $request->input('format');

            // Сохраняем изображение на сервере
            // $path = $image->store('/storage');

            $path = public_path() . '/uploads/images/store/';
            $file->move($path, $file->getClientOriginalName());
            return response()->json([
                "image_url" => '/uploads/images/store/' . $file->getClientOriginalName(),
            ]);
            // Возвращаем URL изображения и формат клиенту
            // return response()->json([
            //     'image_url' => asset($path),
            //     'format' => $format,
            // ]);
        }

        return response()->json([
            'message' => 'Изображение не найдено.',
        ], 400);
    }

    public function img($img_name){
        $storagePath = storage_path('app/images/t7kjRzTRlGov5LOvcAPmtLafRfrkPmm1W7r550x1.png');
        return response()->file($storagePath);
    }

    public function destroy($task_id)
    {
        if (Auth::check()) {
            $task = Todolist_task::findOrFail($task_id);
            if ($task->user_id = Auth::user()->id) {
                $task->delete();
                return "Success deleted task " . $task_id;
            }
        }
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
    }

    private function store_img($image)
    {
        $image = $request->file('image');

        // Save the image on the server
        $path = $image->store('images');

        return response()->json([
            'image_url' => asset($path),
            'format' => $format,
        ]);
    }

    private function getTasks($user_id)
    {
        $tasks = User::all()->where("id", "=", $user_id)->first()->todolist_tasks;
        $tasks_arr = [];
        foreach ($tasks as $task) {
            $tasks_arr[] = [
                "id" => $task->id,
                "title" => $task->title,
                "full_text" => $task->full_text,
                "image" => $task->img_src,
                "completed" => $task->completed,
            ];
        };
        return $tasks_arr;
    }
}
