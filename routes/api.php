<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/users', [UserController::class, 'index'])->name("user.list");
Route::post('/user', [UserController::class, 'store'])->name("user.store");
Route::get('user/{id}', [UserController::class, 'show'])->name("user.show");
Route::post('/user/{id}', [UserController::class, 'update'])->name("user.update");
Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name("user.delete");
