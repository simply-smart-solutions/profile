<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummernoteController extends Controller
{
    public function upload(Request $request) {

        $img = $request->file('image');
        $filename = uniqid() . '.' . $img->getClientOriginalExtension();
        $img->move('public/images/', $filename);

        return url('/') . "/public/images/" . $filename;

    }
    public function uploadFileManager(Request $request) {

        // \Log::info($request->all());

        $items = $request->items;
        if(is_array($items)){
            // return $items;
            $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'jfif', 'avif');
            foreach ($items as $key => $item) {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowedExts)) {
                    return response()->json(['status' => 'error', 'message' => "Only png, jpg, jpeg, svg images are allowed"]);
                }
            }

            $urls = [];
            foreach ($items as $key => $item) {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                copy($item, public_path('images/' . $filename));
                $urls[] = url('public/images/' . $filename);
            }

            return response()->json(['status' => 'success', 'urls' => $urls]);
        }else{
            return response()->json(['status' => 'failed', 'urls' => '']);
        }
    }
}
