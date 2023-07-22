<?php

namespace App\Http\Controllers;

use App\Models\Todolist_task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Intervention\Image\Facades\Image as Image;

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

        if (Auth::check()) {
            $response = [];
            $img_src = null;
            if ($request->hasFile('todo-img') && $request->file('todo-img')->isValid()) {
                // if (TaskImageController::storeImageValidation($request->file('todo-img'))) {
                    $TaskImageClass = new TaskImageController;
                    $img_src = $TaskImageClass->storeImage($request->file("todo-img"), $request->user()->id); //save and get name file
                // }
            } else {
                $response[] = ["BAD" => "Image not stored"];
            };
            Todolist_task::create([
                "title" => $request->title,
                "full_text" => $request->full_text,
                "completed" => 0,
                "img_src" => $img_src,
                "user_id" => Auth::user()->id,
            ]);
            $response[] = ["WELL" => "todolist.store good"];
            return response()->json($response);
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
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

    private function getTasks($user_id)
    {
        $tasks = User::all()->where("id", "=", $user_id)->first()->todolist_tasks;
        $tasks_arr = [];
        foreach ($tasks as $task) {
            $tasks_arr[] = [
                "id" => $task->id,
                "title" => $task->title,
                "full_text" => $task->full_text,
                "img_src" => $task->img_src,
                "completed" => $task->completed,
            ];
        };
        return $tasks_arr;
    }
}
