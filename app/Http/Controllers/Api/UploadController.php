<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(UploadRequest $request){
        $file = $request->file("file");

        $fileNameWithExtension = $file->getClientOriginalName();
        $path = public_path("/uploads/");
        $move =$file->move($path,$fileNameWithExtension);

        if($move){

            $fileURL = url('/'.$fileNameWithExtension);

            return response()->json([
                "url" => $fileURL
            ]);
        }
    }
}
