@extends('layouts.main')
@section('title', 'Product')
@section('container')
@section('link')
<style>
    .pagination{
        justify-content: center!important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection
    <div class="row">
        <div class="col-8">
            @if (session()->has('success'))
                <div class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        $('#successAlert').alert('close');
                    }, 5000);
                </script>
            @endif
            @if (session()->has('error'))
                <div class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        $('#errorAlert').alert('close');
                    }, 5000);
                </script>
            @endif
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
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
                                    <div class="price d-flex flex-row align-items-center"> <span
                                            class="act-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                            
                                        {{-- <div class="ml-2"> <small class="dis-price">$59</small> <span>40% OFF</span>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pt-1">
                                        <div> 
                                            <i class="fa fa-star" style="color: #ffd250"></i> 
                                            <span>
                                                {{ $product->orderDetails->pluck('review.rating.value')->filter()->avg() }} | 
                                                {{ $product->orderDetails->where('order.has_paid', 1)->sum('quantity') }} Sold
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                {{-- @if ($user->addresses->where('isMain', 1)->first())
                                    @php
                                        $couriers = ['jne', 'tiki', 'pos'];
                                        $ongkirResults = [];

                                        foreach ($couriers as $courier) {
                                            $responseCost = Http::withHeaders([
                                                'key' => 'c02b93cf40f1b5bc247494c12cae4148',
                                            ])->post('https://api.rajaongkir.com/starter/cost', [
                                                'origin' => $product->store->address->city->id,
                                                'destination' => $user->addresses->where('isMain', 1)->first()->city->id,
                                                'weight' => $product->weight,
                                                'courier' => $courier,
                                            ]);

                                            $content = json_decode($responseCost, false);
                                            $ongkirResults[$courier] = $content->rajaongkir->results;
                                        }
                                    @endphp
                                    <div class="mt-4 mb-3">
                                        <h6>Shipping : to {{ $user->addresses->where('isMain', 1)->first()->city->name }}
                                        </h6>
                                        <label style="font-weight: 500">Ongkos Kirim : </label>
                                        <a id="example" tabindex="0" class="badge bg-primary text-decoration-none"
                                            role="button" data-bs-toggle="popover">click</a>
                                    </div>
                                    <div hidden>
                                        <div data-name="popover-content">
                                            <div class="input-group">

                                                @foreach ($ongkirResults as $results)
                                                    @foreach ($results as $item)
                                                        @if ($item->costs)
                                                            <h6 class="mb-2">{{ $item->name }}</h6>
                                                        @endif
                                                        <hr>
                                                        @foreach ($item->costs as $cost)
                                                            <label class="mb-2">{{ $cost->service }}
                                                                @foreach ($cost->cost as $harga)
                                                                    Rp{{ $harga->value }} | est :
                                                                    {{ str_replace(' HARI', '', $harga->etd) }} Days
                                                                @endforeach
                                                            </label>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}
                                <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="quantity" class="col-sm-3 col-form-label"
                                            style="font-weight: 500">Quantity</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" id="quantity" name="quantity"
                                                min="1" max="{{ $product->stock }}" value="1"
                                                oninput="handleInputChange()">
                                        </div>
                                        <label class="col-sm-4 col-form-label text-muted">{{ $product->stock }}
                                            left</label>
                                    </div>
                                    <div class="cart mt-4 align-items-center">
                                        @if ($product->stock == 0)
                                            <button class="btn btn-muted text-uppercase mr-2 px-4">Add to cart</button>
                                        @else
                                            <button class="btn btn-danger text-uppercase mr-2 px-4" type="submit">Add to
                                                cart</button>
                                        @endif
                                    </div>
                                </form>
                                <div class="cart mt-4 align-items-center">
                                    <button class="btn btn-danger text-uppercase mr-2 px-4">Buy Now</button>
                                    <i class="fa fa-heart text-muted mx-3"></i>
                                    <i class="fa fa-share text-muted"></i>
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

        <div class="row mt-5 justify-content-center">
            <div class="col-12 shadow">
                <div class="row align-items-center pt-3">
                    <span class="fs-5">Product reviews ({{ $product->orderDetails->filter(function ($orderDetail) {
                        return $orderDetail->review !== null;
                    })->count() }})</span>
                </div><hr>
                @php
                    $reviews = $product->orderDetails->pluck('review')->filter(); 
                    $perPage = 5;
                    $currentPage = request('page', 1);
                    $reviews = new \Illuminate\Pagination\LengthAwarePaginator(
                        $reviews->forPage($currentPage, $perPage),
                        $reviews->count(),
                        $perPage,
                        $currentPage,
                        ['path' => request()->url()],
                    );
                @endphp

                @foreach ($reviews as $review)
                    <div class="row">
                        <div class="col-1 text-end">
                            @if ($review->orderDetail->order->user->image)
            <img src="{{ asset('storage/'.$review->orderDetail->order->user->image->url) }}" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">
            @else
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="mdo" width="32" height="32" class="rounded-circle border border-dark">           
            @endif

                        </div>
                        <div class="col-11 p-0">
                            <div class="row">
                                <small>{{ $review->orderDetail->order->user->name }}</small>
                                <span> 
                                    @for ($i = 1; $i <= $review->rating->value; $i++)
                                    <i class="fa fa-star" style="color: #ffd250"></i>
                                    @endfor
                                     Star
                                </span>
                                <small class="text-muted">{{ $review->updated_at->format('d-m-Y H:i') }}</small>
                            </div>
                            <div class="row mt-2">
                                <span>{{ $review->comment }}</span>
                            </div>
                            @if ($review->images)
                                <div class="row mt-2">
                                    @foreach ($review->images as $image)
                                        <div class="col-1" style="margin-right: -20px;">
                                            <img src="{{ asset('storage/' . $image->url) }}" alt="mdo" width="64"
                                                height="64" class=" border border-dark">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                @endforeach

                @if ($reviews->isEmpty())
                    <div class="row text-center p-5">
                        <h1>This Product Doesn't Have Review</h1>
                    </div>
                @endif

                {{ $reviews->links() }}

            </div>
        </div>
    </div>
    <script src="{{ asset('js/product.js') }}"></script>
    <script>
        $(document).ready(function() {

            var options = {
                html: true,
                //html element
                //content: $("#popover-content")
                content: $('[data-name="popover-content"]')
                //Doing below won't work. Shows title only
                //content: $("#popover-content").html()

            }
            var exampleEl = document.getElementById('example')
            var popover = new bootstrap.Popover(exampleEl, options)
        })
    </script>
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
