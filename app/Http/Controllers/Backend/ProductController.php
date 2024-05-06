<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if(session('products')) {
            $products = session('products');
            $name = session('name');
            $items = 10;

            session()->forget('products');
            session()->forget('name');
        }
        else {
            $items = $request->items ?? 10;
            $products = Product::where('status', '!=', '0')->orderBy('id', 'desc')->paginate($items);
            $name = null;
        }

        foreach($products as $product) {
            $product->action = '
            <a id="'.$product->id.'" class="view btn btn-success btn-sm mx-1 rounded-0" title="View"><i class="bi bi-back"></i></a>
            <a id="'.$product->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
            <a id="'.$product->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

            $product->category = Category::find($product->category)->name;
            $product->status = ($product->status == '1') ? '<span class="badge text-bg-success">Activate</span>' : '<span class="badge text-bg-danger">Deactivate</span>';
        }

        $categories = Category::where('status', '1')->get();

        return view('backend.products', [
            'products' => $products,
            'categories' => $categories,
            'name' => $name,
            'items' => $items
        ]);
    }
                                                                              
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|max:2048'
        ], [
            'image.image' => 'The uploaded file must be an image',
            'image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Creation failed!');
        }

        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $image->storeAs('public/product_images', $image_name);

        $latest_product = Product::where('status', '1')->orderBy('id', 'desc')->first();

        $id = $latest_product ? $latest_product->id + 1 : 1;
        $product_id = 'P' . str_pad($id, 3, '0', STR_PAD_LEFT);

        $product = new Product();
        $data = $request->except('image');
        $data['product_id'] = $product_id;
        $data['image'] = $image_name;
        $product->create($data);

        return redirect()->route('admin.products.index')->with('success', 'Successfully created!');
    }

    public function show(Product $product)
    {
        return response($product);
    }

    public function edit(Product $product)
    {
        return response($product);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'new_image' => 'image|max:2048'
        ], [
            'new_image.image' => 'The uploaded file must be an image',
            'new_image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update failed!');
        }

        if($request->file('new_image') != null) {
            if($request->old_profile_image) {
                Storage::delete('public/product_images/' . $request->old_image);
            }

            $image = $request->file('new_image');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/product_images', $image_name);
        }
        else {
            $image_name = $request->old_image;
        }

        $data = $request->except('old_image', 'new_image');
        $data['image'] = $image_name;
        $product->fill($data)->save();
        
        return redirect()->route('admin.products.index')->with('success', "Successfully updated!");
    }

    public function destroy(Product $product)
    {
        $product->status = '0';
        $product->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['products', 'name'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.products.index');
        }

        $name = $request->name;

        $products = Product::where('status', '!=', '0');

        if($name != null) {
            $products->where('name', 'like', '%' . $name . '%');
        }

        $products = $products->orderBy('id', 'desc')->paginate(10);

        session([
            'products' => $products,
            'name' => $name
        ]);

        return redirect()->route('admin.products.index');
    }
}