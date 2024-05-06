<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function homepage()
    {
        $products = Product::where('status', '!=', '0')->orderBy('id', 'desc')->paginate(6);
        
        return view('frontend.homepage', [
            'products' => $products
        ]);
    }

    public function singleProduct(Product $product) {
        return view('frontend.single_product', [
            'product' => $product
        ]);
    }
}