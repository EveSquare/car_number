<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Number_plate;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use thiagoalessio\TesseractOCR\TesseractOCR;

class HomeController extends Controller
{
    //
    public function home_get(Request $req)
    {
        return view('home', [
            'rn' => $req->input('rn'),
            'cn' => $req->input('cn'),
            'hi' => $req->input('hi'),
            's1' => intval($req->input('s1')),
            's2' => intval($req->input('s2')),
            's3' => intval($req->input('s3')),
            's4' => intval($req->input('s4')),
        ]);
    }

    public function home_post(Request $req)
    {
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
    }
}
