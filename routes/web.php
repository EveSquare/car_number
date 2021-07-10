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
    
    return view('home', [
        'rn' => $req->input('rn'),
        'cn' => $req->input('cn'),
        'hi' => $req->input('hi'),
        's1' => intval($req->input('s1')),
        's2' => intval($req->input('s2')),
        's3' => intval($req->input('s3')),
        's4' => intval($req->input('s4')),
    ]);
})->name('home');

Route::post('/', function (Request $req) {
    //user_instanse
    $user = $req->user();

    //入力チェック
    $record = [
        'regional_name' => $req->input('regional_name'),
        'category_number' => $req->input('category_number'),
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

    if($upload_image) {
        $path = $upload_image->store('uploads',"public");
    }

    $ocr = (new TesseractOCR(storage_path('app/public').'/'.$path))->lang('jpn')->run();
    
    $rn = null;
    $cn = null;
    $hi = null;
    $s1 = null;
    $s2 = null;
    $s3 = null;
    $s4 = null;
    $query_array = [];

    $ocr = preg_replace("/[^ぁ-んァ-ンーa-zA-Z0-9一-龠０-９\-\r]+/u", '', $ocr);
    
    str_replace(' ', '', $ocr);
    preg_match('/[一-龠]{2,3}/u', $ocr, $rn);
    if(!empty($rn)){
        $query_array['rn'] = $rn[0];
    }

    if(preg_match('/[\d]{3}/u', $ocr, $cn)){
        str_replace($cn, '', $ocr);
    }
    if(!empty($cn)){
        $query_array['cn'] = $cn[0];
    }

    preg_match('/[あ-ん]/u', $ocr, $hi);
    if(!empty($hi)){
        $query_array['hi'] = $hi[0];
    }

    $count = 0;
    foreach(str_split($ocr) as $val){
        if(preg_match('/[0-9]/u', $val)){
            switch ($count){
                case 0:
                    $s1 = $val;
                    if(!empty($s1)){
                        $query_array['s1'] = $s1[0];
                    }
                    break;
                case 1:
                    $s2 = $val;
                    if(!empty($s2)){
                        $query_array['s2'] = $s2[0];
                    }
                    break;
                case 2:
                    $s3 = $val;
                    if(!empty($s3)){
                        $query_array['s3'] = $s3[0];
                    }
                    break;
                case 3:
                    $s4 = $val;
                    if(!empty($s4)){
                        $query_array['s4'] = $s4[0];
                    }
                    break;
                default:
                    break;
            }
            $count += 1;
        }
    }

    return redirect()->route('home', $query_array);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
