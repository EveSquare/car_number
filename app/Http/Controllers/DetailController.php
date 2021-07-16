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
        

        function round_par_count($val, $comment_count) {
            
            if($val){
                $val = round(100*($val/$comment_count), 0);
            }else{
                $val = 0;
            }

            return $val;
        }

        $per_positive = round_par_count($positive, $comment_count);
        $per_negative = round_par_count($negative, $comment_count);
        $per_normal = round_par_count($normal, $comment_count);
    
        return view('detail', [
            'id' => $number_plate->id,
            'comments' => $comments,
            'per_positive' => $per_positive,
            'per_negative' => $per_negative,
            'per_normal' => $per_normal,
        ]);
    }
}
