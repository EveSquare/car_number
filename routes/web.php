<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Number_plate;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    echo var_dump($user);
    return view('home');
});

Route::post('/', function (Request $req) {
    //user_instanse
    $user = $req->user();

    //入力チェック
    $record = [
        'regional_name' => $req->input('regional_name'),
        'category_number' => intval($req->input('category_number')),
        'hiragana' => $req->input('hiragana'),
        'specified_number_1' => intval($req->input('specified_number_1')),
        'specified_number_2' => intval($req->input('specified_number_2')),
        'specified_number_3' => intval($req->input('specified_number_3')),
        'specified_number_4' => intval($req->input('specified_number_4')),
        'color'=> $req->input('colors'),
    ];
    
    try{
        $number_plate = Number_plate::where($record)->firstOrFail();
    }catch(ModelNotFoundException $e){
        $number_plate = Number_plate::create($record);
        echo '見つかりませんでした'. var_dump($number_plate->id);
    }

    return redirect()->route('detail', [
        'rn' => $number_plate->regional_name,
        'cn' => $number_plate->category_number,
        'hi' => $number_plate->hiragana,
        's1' => $number_plate->specified_number_1,
        's2' => $number_plate->specified_number_2,
        's3' => $number_plate->specified_number_3,
        's4' => $number_plate->specified_number_4,
        'cl' => $number_plate->color,
    ]);
});

Route::get('detail/', function(Request $req) {

    echo var_dump($req->query('rn'));

    return view('detail');
})->name('detail');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
