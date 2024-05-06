<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function view(Product $product)
    {
        $product->image = ($product->image != null) ? url('') . '/storage/product_images/' . $product->image : null;
        $product->status = ($product->status == '1') ? 'Activate' : 'Deactivate';

        $category = Category::find($product->category);
        $category->status = ($category->status == '1') ? 'Activate' : 'Deactivate';
        $category = $category->makeHidden([
            'created_at',
            'updated_at'
        ]);
        $product->category = $category;

        $product = $product->makeHidden([
            'created_at',
            'updated_at'
        ]);

        return response()->json([
            'http_status' => 200,
            'http_status_message' => 'Success',
            'data' => $product
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'directions' => 'required',
            'price' => 'required',
            'in_stock' => 'required',
            'status' => 'required',
            'image' => 'required|image|max:2048'
        ], [
            'image.image' => 'The uploaded file must be an image',
            'image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return response()->json([
                'http_status' => 400,
                'http_status_message' => 'Bad Request',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $latest_product = Product::where('status', '1')->orderBy('id', 'desc')->first();
        $id = $latest_product ? $latest_product->id + 1 : 1;
        $product_id = 'P' . str_pad($id, 3, '0', STR_PAD_LEFT);

        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $image->storeAs('public/product_images', $image_name);

        $product = new Product();
        $data = $request->except('image');
        $data['product_id'] = $product_id;
        $data['image'] = $image_name;
        $product->create($data);

        return response()->json([
            'http_status' => 200,
            'http_status_message' => 'Success',
            'message' => 'Product created successfully'
        ], 200);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'directions' => 'required',
            'price' => 'required',
            'in_stock' => 'required',
            'status' => 'required',
            'image' => 'image|max:2048'
        ], [
            'image.image' => 'The uploaded file must be an image',
            'image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return response()->json([
                'http_status' => 400,
                'http_status_message' => 'Bad Request',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if($request->file('image') != null) {
            if($request->old_image) {
                Storage::delete('public/product_images/' . $request->old_image);
            }

            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/product_images', $image_name);
        }
        else {
            $image_name = $product->image;
        }

        $data = $request->except('image');
        $data['image'] = $image_name;
        $product->fill($data)->save();

        return response()->json([
            'http_status' => 200,
            'http_status_message' => 'Success',
            'message' => 'Product updated successfully'
        ], 200);
    }

    public function delete(Product $product)
    {
        $product->status = '0';
        $product->save();

        return response()->json([
            'http_status' => 200,
            'http_status_message' => 'Success',
            'message' => 'Product deleted successfully'
        ], 200);
    }
}