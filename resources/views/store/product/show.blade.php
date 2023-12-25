@extends('layouts.main')
@section('title', 'Product')
@section('container')
<div class="row">
    <div class="col-8">
        @if (session()->has('success'))     
            <div  class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                <div id="successAlert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>           
            <script>
                setTimeout(function () {
                    $('#successAlert').alert('close');
                }, 5000);
            </script>         
        @endif
        @if (session()->has('error'))     
            <div  class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>           
            <script>
                setTimeout(function () {
                    $('#errorAlert').alert('close');
                }, 5000);
            </script>         
        @endif
    </div> 
</div>
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    <img id="main-image" src="{{ asset('storage/' . $product->images->first()->url) }}"
                                        width="250" />
                                </div>
                                <div class="thumbnail text-center">
                                    @foreach ($product->images as $image)
                                        <img onclick="change_image(this)" src="{{ asset('storage/' . $image->url) }}"
                                            width="70">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-4">
                                <div class="mt-4 mb-3"> 
                                    {{-- <span class="text-uppercase text-muted brand">Orianz</span> --}}
                                    <h5 class="text-uppercase">{{ $product->name }}</h5>
                                    <div class="price d-flex flex-row align-items-center"> <span class="act-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        {{-- <div class="ml-2"> <small class="dis-price">$59</small> <span>40% OFF</span>
                                        </div> --}}
                                    </div>
                                </div>
                                <form action="{{ route('cart.store',$product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="quantity" class="col-sm-3 col-form-label" style="font-weight: 500">Quantity</label>
                                        <div class="col-sm-3">
                                          <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" oninput="handleInputChange()">
                                        </div>
                                        <label class="col-sm-4 col-form-label text-muted">{{ $product->stock }} left</label>
                                    </div>
                                    <div class="cart mt-4 align-items-center">
                                        <button class="btn btn-danger text-uppercase mr-2 px-4" type="submit">Add to cart</button> 
                                    </div>
                                </form>
                                <div class="cart mt-4 align-items-center">
                                <button class="btn btn-danger text-uppercase mr-2 px-4">Buy Now</button> 
                                <i class="fa fa-heart text-muted mx-3"></i> 
                                <i class="fa fa-share-alt text-muted"></i>
                            </div>
                                {{-- <div class="sizes mt-5">
                                    <h6 class="text-uppercase">Size</h6> <label class="radio"> <input type="radio"
                                            name="size" value="S" checked> <span>S</span> </label> <label
                                        class="radio"> <input type="radio" name="size" value="M"> <span>M</span>
                                    </label> <label class="radio"> <input type="radio" name="size" value="L">
                                        <span>L</span> </label> <label class="radio"> <input type="radio" name="size"
                                            value="XL"> <span>XL</span> </label> <label class="radio"> <input
                                            type="radio" name="size" value="XXL"> <span>XXL</span> </label>
                                </div> --}}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('js/product.js') }}"></script>

    <script>
        function handleInputChange() {
            var inputElement = document.getElementById("quantity");
            var maxValue = parseInt(inputElement.max);

            if (inputElement.value > maxValue) {
                inputElement.value = maxValue;
            }
        }
    </script>

@endsection
