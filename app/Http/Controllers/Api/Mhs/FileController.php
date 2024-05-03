<?php

namespace App\Http\Controllers\Api\Mhs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function getImage($filename)
    {
        $path = storage_path('app/public/soal/' . $filename);


        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);
        ob_end_clean();
        return Response::make($file, 200)->header("Content-Type", $type);
    }
    public function getImageEssay($filename)
    {
        $path = storage_path('app/public/soalessay/' . $filename);


        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);
        ob_end_clean();
        return Response::make($file, 200)->header("Content-Type", $type);
    }
}
