@extends('layouts.frontend')

@section('title', $product->name)

@section('content')

    <div class="container-fluid single-product">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-7 px-0">
                    @if($product->image != null)
                        <img src="{{ asset('storage/product_images/' . $product->image) }}" class="image" alt="Product Image">
                    @else
                        <img src="{{ asset('storage/no_image.jpg') }}" class="image" alt="Product Image">
                    @endif
                </div>
                <div class="col-5 right">
                    <p class="name">{{ $product->name }}</p>
                    <p class="price">Rs. {{ $product->price }}</p>
                    <p class="category">Category: {{ App\Models\Category::find($product->category)->name }}</p>
                    <p class="description">{{ $product->description }}</p>
                    <div class="directions">{!! $product->directions !!}</div>
                </div>
            </div>

        </div>
    </div>

@endsection