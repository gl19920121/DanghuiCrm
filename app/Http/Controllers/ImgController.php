<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;

class ImgController extends Controller
{
    public function exportResume(Resume $resume)
    {
        // 1.创建画布
        $width = 600;
        $height= 400;
        $image = imagecreatetruecolor($width, $height);

        // 4.输出或保存
        header('content-type:image/jpg');
        imagejpeg($image);

        imagedestroy($image);

        $name = "$resume->name";
        return response()->download($image, $name, $headers = ['Content-Type'=>'application/zip;charset=utf-8'])->deleteFileAfterSend(true);
    }
}
