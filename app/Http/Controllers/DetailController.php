<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Number_plate;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DetailController extends Controller
{
    //
    public function detail(Request $req)
    {
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
    }
}
