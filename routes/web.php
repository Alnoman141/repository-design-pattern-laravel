<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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
// Route::get('/', [UserController::class, 'index'])->name("user.list");
// Route::post('/user', [UserController::class, 'store'])->name("user.store");
// Route::get('user/{id}', [UserController::class, 'edit'])->name("user.edit");
// Route::post('/user/{id}', [UserController::class, 'update'])->name("user.update");
// Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name("user.delete");