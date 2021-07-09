<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Number_plate;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

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

    $record = [
        'regional_name' => $req->input('rn'),
        'category_number' => intval($req->input('cn')),
        'hiragana' => $req->input('hi'),
        'specified_number_1' => intval($req->input('s1')),
        'specified_number_2' => intval($req->input('s2')),
        'specified_number_3' => intval($req->input('s3')),
        'specified_number_4' => intval($req->input('s4')),
        'color'=> $req->input('cl'),
    ];

    try{
        $number_plate = Number_plate::where($record)->firstOrFail();
    }catch(ModelNotFoundException $e){
        $number_plate = Number_plate::create($record);
    }

    $comments = Comment::where('number_plate_id', $number_plate->id)->latest()->get();

    $comment_count = $comments->count();
    $positive = 0;
    $normal = 0;
    $negative = 0;

    foreach ($comments as $comment){
        switch ($comment->evaluation){
            case '+':
                $positive += 1;
                break;
            case '-':
                $negative += 1;
                break;
            default:
                $normal += 1;
        }
    }

    if($positive){
        $per_positive = round(100*($positive/$comment_count), 0);
    }else{
        $per_positive = 0;
    }

    if($negative){
        $per_negative = round(100*($negative/$comment_count), 0);
    }else{
        $per_negative = 0;
    }

    if($normal){
        $per_normal = round(100*($normal/$comment_count), 0);
    }else{
        $per_normal = 0;
    }

    return view('detail', [
        'id' => $number_plate->id,
        'comments' => $comments,
        'per_positive' => $per_positive,
        'per_negative' => $per_negative,
        'per_normal' => $per_normal,
    ]);
})->name('detail');

Route::get('newcomment/{id}', function() {
    return view('newcomment');
});
Route::post('newcomment/{id}', function(Request $req, $id) {

    // $number_instance = DB::table('number_plates')->find($id);
    $comment = [
        'user_id' => $req->user()->id,
        'number_plate_id' => $id,
        'evaluation' => $req->input('evaluation'),
        'title' => $req->input('title'),
        'content' => $req->input('content'),
        'created_at' => date('Y-m-d H:i:s'),
    ];
    
    DB::table('comments')->insert($comment);

    return view('comment_add_success');
});

Route::get('upload/', function() {
    return view('upload-page');
});

Route::post('upload/', function(Request $req) {

    $req->validate([
        'image' => 'required|file|image|mimes:png,jpeg'
    ]);

    $upload_image = $req->file('image');
    $file_name = $upload_image->getFilename();

    if($upload_image) {
        $path = $upload_image->store('uploads',"public");
    }

    // preg_match( '/[^一-龠]/u', '文字列' 漢字判定
    echo (new TesseractOCR(storage_path('app/public').'/'.$path))
        ->lang('jpn')
        ->run();

    return view('home');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
