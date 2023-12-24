@extends('layouts.main')
@section('title','Dashboard')
@section('link')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection
@section('container')
<div class="row">
    <div class="col-12">
        @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" style="width: 100%" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
    </div>
</div>
<div class="mt-5">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-2 mb-4">
        <a href="{{ route('products.show',$product->id) }}" class="text-decoration-none">
            <div class="card">
                <div class="image-container">
                    <div class="first">
                        <div class="d-flex justify-content-between align-items-center"> <span class="discount">-25%</span> 
                           
                            {{-- <span class="wishlist"><i class="fa fa-heart-o"></i></span>  --}}
                        </div>
                    </div> <img src="{{ asset('storage/' . $product->images->first()->url) }}" class="img-fluid rounded thumbnail-image">
                </div>
                <div class="product-detail-container p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="dress-name">{{ $product->name }}</h5>
                        <div class="d-flex flex-column mb-2"> <span class="new-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span> 
                            {{-- <small class="old-price text-right">$5.99</small>  --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1">
                        <div> <i class="fa fa-star-o rating-star"></i> <span class="rating-number">4.8 | 1 Terjual</span> </div> <div><span class="rating-number">Kota Medan</span></div>
                    </div>
                </div>
            </div>
        </a>

        </div>
        @endforeach


    </div>
</div>


@endsection