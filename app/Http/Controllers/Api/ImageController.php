<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller{
    function uploadImageToGcp($image,$folderName){

        $image = str_replace('\\','',$image);
        $baseimage=base64_encode(file_get_contents($image));
        $pngimage=null;
        $fileName = time() . '.png';
        /*$txtFileName=time().'.txt';*/
        $filePath=storage_path('app\\images\\', $fileName);
        $pngimage=$filePath.$fileName;
        /*$txtimage=$filePath.$txtFileName;*/
        $pngimage=$this->base64ToImage($baseimage,$pngimage);
        /*$txtimage=$this->base64ToText($baseimage,$txtimage);*/

        $s3 = Storage::disk(config('filesystems.cloud'));


        $env = config('app.env') == 'production' ? '' : '';

        $basePath = $env . $folderName .'/';

        $filePath = $basePath . $fileName;

        $thumbPath = $basePath . 'thumbs/' . $fileName;
        $img = Image::make($pngimage)->resize(450, null, function ($constraint) {
            $constraint->aspectRatio();
        });


        $s3->put($filePath, file_get_contents($pngimage), 'public');
        $s3->put($thumbPath, (string)$img->encode('png', 90), 'public');
        /*$s3->put($txtFilePath, file_get_contents($pngimage), 'public');*/

        stop($s3);

        return $fileName;
    }

    function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);

        return $output_file;
    }


    public function uploadToS3($document, $folderPath, $type = ''){
        // $s3 = Storage::disk("s3");
        // if($type == 'document'){
        //     $s3->put($folderPath, file_get_contents($document), 'public');
        // }else{
        //     $s3->put($folderPath, file_get_contents($document), 'public');
        // }
        // Storage::disk('s3')->put($folderPath, file_get_contents($document));
        Storage::disk('s3')->put($folderPath, file_get_contents($document) , [
            'ContentDisposition' => 'attachment'
       ]);
        $url = Storage::disk('s3')->url($folderPath);
        // $url = $s3->url($folderPath);
        return $url;
    }
}
