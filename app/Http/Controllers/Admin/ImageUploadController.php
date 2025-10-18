<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('uploads', 'public');
            $url = Storage::url($path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}



