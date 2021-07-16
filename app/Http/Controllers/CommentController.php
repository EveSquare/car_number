<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function comment_get()
    {
        return view('newcomment');
    }

    public function comment_post(Request $req, $id)
    {
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
    }
}
