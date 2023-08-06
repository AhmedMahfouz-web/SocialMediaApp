<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoostController;
use App\Models\Boost;

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
Route::get('createtweet', function () {
    return view('createTweet');
});
Route::get('boosts',function()
{
    return view('boosts');
});
Route::get('/boosts', [BoostController::class, 'index'])->name('boosts.index');
Route::get('/boost',[BoostController::class,'create']);
Route::post('/boost', [BoostController::class, 'store']);
Route::get('/boosts/{id}/edit', [BoostController::class, 'edit'])->name('boosts.edit');
Route::put('/boosts/{id}', [BoostController::class, 'update'])->name('boosts.update');
// Route::get('/Boost', [BoostController::class, '']);

// Route::get('/boosts/{id}', [BoostController::class, 'show']);
