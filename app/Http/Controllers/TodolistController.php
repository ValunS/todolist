<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodolistController extends Controller
{
    public function index()
    {
        // dd($this->getTasksWithTags(Auth::user()->id));
        if (Auth::check()) {
            $tasks = $this->getTasksWithTags(Auth::user()->id);
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
            $tasks = $this->getTasksWithTags(Auth::user()->id);
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
            $response = []; //collect all messages
            $img_src = null;
            $createdTask = Task::create([
                "title" => $request->title,
                "full_text" => $request->full_text,
                "completed" => 0,
                "img_src" => $img_src,
                "user_id" => Auth::user()->id,
            ]);
            if ($request->hasFile('todo-img') && $request->file('todo-img')->isValid()) {
                $currTaskId = $createdTask->id;
                $TaskImageClass = new TaskImageController;
                $img_src = $TaskImageClass->storeImage($currTaskId, $request->file("todo-img")); //store img and get src
                $createdTask->update(["img_src" => $img_src]); //put stored img_src to task
            } else {
                $response[] = ["BAD" => "Image not stored"];
            };

            $response[] = ["WELL" => "todolist.store good" . "   " . $createdTask];
            return response()->json($response);
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
    }

    public function update($id, Request $request)
    {
        if (Auth::check()) {
            $response = []; //collect all messages
            $gettedData = $request->all();
            $dataForUpdateTask = [];
            $this->addFieldIfExists($gettedData, $dataForUpdateTask, "title");
            $this->addFieldIfExists($gettedData, $dataForUpdateTask, "full_text");
            $this->addFieldIfExists($gettedData, $dataForUpdateTask, "completed");
            if ($request->hasFile('task-img') && $request->file('task-img')->isValid()) { //add ["img_src"]
                $TaskImageClass = new TaskImageController;
                $dataForUpdateTask["img_src"] = $TaskImageClass->storeImage($id, $request->file("task-img"));
            } else {
                $response[] = ["BAD" => "Image not stored"];
            };
            $Task = Task::find((int) $id)->update(
                $dataForUpdateTask
            );

            $response[] = ["WELL" => "todolist.update good" . "   " . $Task];
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
            $task = Task::findOrFail($task_id);
            if ($task->user_id == Auth::user()->id) {
                $task->delete();
                return "Success deleted task " . $task_id;
            }
        }
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the todolist.',
            ])->onlyInput('email');
    }

    private function addFieldIfExists(&$arrayElements, &$arrayElements_If_exists, $key, $newKey = null)
    {
        $newKey = $newKey == null ? $key : $newKey; //newKey = $key if does not exists
        if (array_key_exists($key, $arrayElements)) {
            $arrayElements_If_exists[$newKey] = $arrayElements[$key];
            return true;
        }
        return false;
    }

    private function getTags($task)
    {
        $tags_arr = [];
        $task_tags = $task->tags;
        foreach ($task_tags as $tag) {
            $tags_arr[] = [
                "id" => $tag->id,
                "name" => $tag->name,
            ];
        }
        return $tags_arr;
    }

    private function getTasksWithTags($user_id)
    {
        $tasks = User::all()->where("id", "=", $user_id)->first()->tasks;
        $tasks_arr = [];
        foreach ($tasks as $task) {

            $tasks_arr[] = [
                "id" => $task->id,
                "title" => $task->title,
                "full_text" => $task->full_text,
                "img_src" => $task->img_src,
                "completed" => $task->completed,
                // "tags" => $this->getTags($task),
            ];
        };
        return $tasks_arr;
    }
}
