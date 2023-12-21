<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ApiController extends Controller
{
    public function storeImage(Request $request) {



        if($request->image) {
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('uploads', $fileName, 'public');

            return response()->json([
                'message' => "Успешно",
                'url' => $fileName,
                'fullUrl' => '/storage/' . $filePath,
            ], 200);
        } else {
            return response()->json([
                'message' => "Ошибка при сохранении изображения"
            ], 500);
        }


    }
}
