<?php

namespace App\Http\Controllers;

use App\Models\Todolist_task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                "image" => $task->img_src,
                "completed" => $task->completed,
            ];
        };
        return $tasks_arr;
    }
}
