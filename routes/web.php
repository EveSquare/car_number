<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Number_plate;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use thiagoalessio\TesseractOCR\TesseractOCR;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UploadController;

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

Route::get('/', [HomeController::class, 'home_get'])->name('home');
Route::post('/', [HomeController::class, 'home_post']);

Route::get('detail/', [DetailController::class, 'detail'])->name('detail');

Route::get('newcomment/{id}', [CommentController::class, 'comment_get']);
Route::post('newcomment/{id}', [CommentController::class, 'comment_post']);

Route::get('upload/', [UploadController::class, 'upload_get']);
Route::post('upload/', [UploadController::class, 'upload_post']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
