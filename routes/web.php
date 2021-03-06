<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks', [TasksController::class, 'index'])->name('tasks.index');
Route::post('tasks', [TasksController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.delete');
Route::patch('/tasks/{task}/toggle', [TasksController::class, 'toggle'])->name('tasks.toggle');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
