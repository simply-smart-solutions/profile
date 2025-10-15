<?php

namespace App\Http\Controllers\User;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(){

        $user = auth()->user();
        $pageTitle = 'All Products';
        $products = $this->productService->index($user);
        return view($this->activeTemplate.'user.products.index',compact('products','pageTitle'));
    }

    public function create (){
        $pageTitle ='Add Product';
        $categories = $this->productService->create();
        return view($this->activeTemplate.'user.products.create',compact('pageTitle','categories'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required',
            'discount' => 'nullable|numeric|between:0,99.99',
            'category_id' => 'required',
            'thumbnail' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'file.*' => ['required', 'file', new FileTypeValidate(['zip', 'rar'])],
        ]);

        // field validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();
        $data = $request;
        $product = $this->productService->storeProduct($data,$user);

        if ($product) {
            return response()->json([
                'message' => 'Product has been created successfully',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Product could not be created. Please try again later.',
            ], 500);
        }
    }

    public function edit($id){
        $pageTitle= 'Update';
        $categories = Category::where('status',1)->get();
        $product = $this->productService->edit($id);
        $productImage = ProductImage::where('product_id', $id)->get();
        return view($this->activeTemplate.'user.products.edit',compact('pageTitle','categories','product','productImage'));

    }

    public function update(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required',
            'discount' => 'nullable|numeric|between:0,99.99',
            'category_id' => 'required',
            'thumbnail' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'file.*' => ['required', 'file', new FileTypeValidate(['zip', 'rar'])],
        ]);
        $user = auth()->user();

        // field validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request;
        $product = $this->productService->updateProduct($data, $user);

        if ($product) {
            return response()->json([
                'message' => 'Product has been updated successfully',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Product could not be updated. Please try again later.',
            ], 500);
        }
    }

    public function imageRemove(Request $request){

        $request->validate([
            'id' => 'required'
        ]);

        $data = $request;
        $imageRemove = $this->productService->imageRemove($data);

        if ($imageRemove) {

            $notify[] = ['success','Product Image has been deleted'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error','Product Image can not deleted. Please try again later.'];
            return back()->withNotify($notify);
            }
    }

    public function delete(Request $request)
    {
        $productId = $request->id;
        $product = $this->productService->deleteProduct($productId);

        if ($product) {

            $notify[] = ['success', 'Product and related images have been deleted successfully'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error','Product can not deleted. Please try again later.'];
            return back()->withNotify($notify);
            }

    }




}
