<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'tasks', 'middleware' => 'auth'], function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/search', [TaskController::class, 'search'])->name('tasks.search');

    Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');
});
