<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\TaskImageController;
use App\Models\Todolist_task;
use Illuminate\Http\Request; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::get('/login', 'login')->name('login');
    Route::post('/store', 'store')->name('store');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

Route::controller(TodolistController::class)->group(function() {
    Route::get('/todolist', 'index')->name('todolist.index');
    Route::get('/todolist/tasks', 'show')->middleware("auth")->name('todolist.show');
    Route::post('/todolist', 'store')->middleware("auth");
    Route::post('/todolist/{task_id}', 'update')->name('todolist.update'); //PUT, but files can be sended by POST
    Route::delete('/todolist/{task_id}', 'destroy')->middleware("auth");
});

Route::controller(TaskImageController::class)->group(function() {
    Route::get('/task-img/{task_id}/{imgName_Or_thumbPath}/{imgName_If_exists}', 'show')->name('image.show');
    Route::get('/task-img/{task_id}/{imgName_Or_thumbPath}/',                    'show')->name('image.show');
});