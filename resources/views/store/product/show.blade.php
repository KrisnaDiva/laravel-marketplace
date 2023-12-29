@extends('layouts.main')
@section('title', 'Product')
@section('container')
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
                                    <div class="price d-flex flex-row align-items-center"> <span
                                            class="act-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        {{-- <div class="ml-2"> <small class="dis-price">$59</small> <span>40% OFF</span>
                                        </div> --}}
                                    </div>
                                </div>
                                @if ($user->addresses->where('isMain', 1)->first())
                                    @php
                                        $couriers = ['jne', 'tiki', 'pos'];
                                        $ongkirResults = [];

                                        foreach ($couriers as $courier) {
                                            $responseCost = Http::withHeaders([
                                                'key' => '9f3bea8727a27ab30805a9c7f5c89739',
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
                                @endif
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
