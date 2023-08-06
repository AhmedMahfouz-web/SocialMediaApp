<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentsVoteController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetsVoteController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });

    Route::post('/tweet/store', [TweetController::class, 'store']);
    Route::post('/tweet/vote', [TweetsVoteController::class, 'store']);
    Route::get('/tweet/get', [TweetController::class, 'index']);
    Route::post('/tweet/delete', [TweetController::class, 'destroy']);
    Route::post('/tweet/delete_ban', [TweetController::class, 'destroy_and_ban']);

    Route::post('comment/store', [CommentsController::class, 'store']);
    Route::post('comment/vote', [CommentsVoteController::class, 'store']);
    Route::post('comment/delete', [CommentController::class, 'destroy']);

    Route::get('chat/get', [ChatController::class, 'index']);
    Route::post('chat', [ChatController::class, 'store']);

    Route::post('chats/receiver-messages', [ChatController::class, 'getReceiverMessages']);
});


Route::post('auth/register', [UsersController::class, 'store']);
Route::post('/login', [UsersController::class, 'login']);
