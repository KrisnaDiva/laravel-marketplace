@extends('layouts.main')
@section('title','Dashboard')
@section('link')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        .pagination{
            justify-content: center!important;
        }
    </style>
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
<div class="row p-4 align-items-center shadow rounded border">
    <div class="col-1">
        <span>Sort By : </span>
    </div>
    <div class="col-11">
        <div class="row justify-content-between align-items-center">
            <div class="col-6 d-flex">
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" action="{{ route('dashboard') }}" id="filterPrice">
                    @if ( request('search') )     
                    <input type="hidden" class="form-control" placeholder="Search..." value="{{ request('search') }}" name="search">
                    @endif
                    <select name="order" class="form-select" id="sortPrice">
                        @if (!request('sortBy') == 'price')           
                        <option value="">Price</option>
                        @endif
                        <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Price : Low to High</option>
                        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Price : High to Low</option>
                    </select>
                    <input type="hidden" name="sortBy" value="price">
                </form>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" action="{{ route('dashboard') }}" id="filterSales">
                    @if ( request('search') )     
                    <input type="hidden" class="form-control" placeholder="Search..." value="{{ request('search') }}" name="search">
                    @endif
                    <input type="hidden" name="sortBy" value="sales">
                    <button class="badge bg-success">BestSeller</button>
                </form>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" action="{{ route('dashboard') }}" id="filterNewest">
                    @if ( request('search') )     
                    <input type="hidden" class="form-control" placeholder="Search..." value="{{ request('search') }}" name="search">
                    @endif
                    <input type="hidden" name="sortBy" value="desc">
                    <button class="badge bg-success">Newest</button>
                </form>
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-2 mb-4">
        <a href="{{ route('products.show',$product->id) }}" class="text-decoration-none">
            <div class="card">
                <div class="image-container">
                    <div class="first">
                        <div class="d-flex justify-content-between align-items-center"> 
                            {{-- <span class="discount">-25%</span>  --}}
                           
                            {{-- <span class="wishlist"><i class="fa fa-heart-o"></i></span>  --}}
                        </div>
                    </div> <img src="{{ asset('storage/' . $product->images->first()->url) }}" class="img-fluid rounded thumbnail-image">
                </div>
                <div class="product-detail-container p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="dress-name">{{ Str::limit($product->name, 10, '...') }}</h5>
                        <div class="d-flex flex-column mb-2"> <span class="new-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span> 
                            {{-- <small class="old-price text-right">$5.99</small>  --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1">
                        <div> <i class="fa fa-star-o rating-star"></i> 
                            <span class="rating-number">{{ $product->orderDetails->pluck('review.rating.value')->filter()->avg() }} |                               
                                {{ $product->orderDetails->where('order.has_paid', 1)->sum('quantity') }} Sold</span> </div> <div><span class="rating-number">{{ $product->store->address->city->name }}</span></div>
                    </div>
                </div>
            </div>
        </a>
        </div>
        @endforeach
    </div>
</div>
    {{ $products->links() }}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Redirect to the URL with the selected sort option when the selection changes
        $('#sortPrice').change(function () {
            if($('#sortPrice').val()==''){
            }else{
                $('#filterPrice').submit();
            }
        });
    });
</script>

@endsection