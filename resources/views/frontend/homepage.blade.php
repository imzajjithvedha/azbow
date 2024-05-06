@extends('layouts.frontend')

@section('title', 'Home')

@section('content')

    <div class="container-fluid homepage position-relative">
        <a href="{{ route('login') }}" class="button">Login</a>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="page-title">Diamond Cosmetics</p>
                </div>
            </div>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-12 col-md-4 mb-4">
                        <div class="product">
                            <a href="{{ route('frontend.single_product', $product->id) }}">
                                <div class="card">
                                    @if($product->image != null)
                                        <img src="{{ asset('storage/product_images/' . $product->image) }}" class="image" alt="Product Image">
                                    @else
                                        <img src="{{ asset('storage/no_image.jpg') }}" class="image" alt="Product Image">
                                    @endif
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <p class="name">{{ $product->name }}</p>
                                                <p class="category">Category: {{ App\Models\Category::find($product->category)->name }}</p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <p class="price">Rs. {{ $product->price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

                {{ $products->links("pagination::bootstrap-5") }}
            </div>
        </div>
    </div>

@endsection