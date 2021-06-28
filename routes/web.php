<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Number_plate;

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

Route::get('/', function (Request $req) {
    $user = $req->user();
    return view('home');
});

Route::post('/', function (Request $req) {
    //user_instanse
    $user = $req->user();

    //入力チェック
    // echo var_dump($req->all());
    echo var_dump(intval($req->input('category_number')));

    $number_plate = Number_plate::firstOrCreate(
        ['regional_name' => $req->input('regional_name')],
        ['category_number'=> intval($req->input('category_number'))],
        ['hiragana' => $req->input('hiragana')],
        ['specified_number_1' => intval($req->input('specified_number_1'))],
        ['specified_number_2' => intval($req->input('specified_number_2'))],
        ['specified_number_3' => intval($req->input('specified_number_3'))],
        ['specified_number_4' => intval($req->input('specified_number_4'))],
        ['color'=> $req->input('colors')],
    );

    $number_plate->save();

    return view('home');
});

Route::get('detail/', function() {
    return view('detail');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
