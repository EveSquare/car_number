<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class UploadController extends Controller
{
    //
    public function upload_get()
    {
        return view('upload-page');
    }

    public function upload_post(Request $req)
    {
        $req->validate([
            'image' => 'required|file|image|mimes:png,jpeg'
        ]);
    
        $upload_image = $req->file('image');
    
        if($upload_image) {
            $path = $upload_image->store('uploads',"public");
        }
    
        $env_path = getenv("PATH");
        putenv("PATH=$env_path:/usr/local/bin");
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
    }
}
