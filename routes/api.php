<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/auth/register', [AuthController::class, 'register']);

// http://localhost:8000/api/search?keyword=utajiri  ->example route for searching
Route::get('/search', [PostController::class, 'search'])->name('posts.search');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/posts', [PostController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function(){
   


    Route::get('/notifications', [NotificationController::class, 'show']);

    Route::post('/post', [PostController::class, 'store'])->middleware('restrictRole:moderator,admin');
    Route::put('/post/{id}', [PostController::class, 'create'])->middleware('restrictRole:writer,admin');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
