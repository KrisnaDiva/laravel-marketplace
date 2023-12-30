@extends('layouts.main')
@section('title', 'Dashboard')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection
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
    <section class="h-100 h-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                            @if ($user->cart)
                                                <h6 class="mb-0 text-muted">{{ $user->cart->cartItems->count() }} Items</h6>
                                        </div>
                                        <hr class="my-4">
                                        @if ($user->cart->cartItems->isNotEmpty())
                                            @foreach ($user->cart->cartItems as $item)
                                                @if ($item->product->stock != 0)
                                                    @if ($item->product->stock < $item->quantity)
                                                        @php
                                                            $item->quantity = $item->product->stock;
                                                            $item->save();
                                                        @endphp
                                                    @endif
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <input type="checkbox" id="checkbox_{{ $item->id }}" value="{{ $item->id }}" class="form-check-input" onclick="handleCheckboxClick(this)">
                                                            <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                                                class="img-fluid rounded-3"
                                                                alt="{{ $item->product->name }}">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <h6 class="text-black mb-0">{{ Str::limit($item->product->name, 30, '...') }}</h6>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                            @if ($item->quantity <= 1)
                                                                <button class="btn "><i
                                                                        class="fa fa-minus text-muted"></i></button>
                                                            @else
                                                                <button class="btn btn-link px-2 decrement-button"
                                                                    data-item-id="{{ $item->id }}">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            @endif

                                                            <input type="number" class="form-control" id="quantity"
                                                                name="quantity" min="1"
                                                                max="{{ $item->product->stock }}"
                                                                value="{{ $item->quantity }}" oninput="handleInputChange()">

                                                            @if ($item->quantity >= $item->product->stock)
                                                                <button class="btn "><i
                                                                        class="fa fa-plus text-muted"></i></button>
                                                            @else
                                                                <button class="btn btn-link px-2 increment-button"
                                                                    data-item-id="{{ $item->id }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            @endif

                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                            <h6 class="mb-0">
                                                                Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">

                                                            <button class="badge bg-danger delete-button"
                                                                data-item-id="{{ $item->id }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4">
                                                @else                                                
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center"
                                                        style="background-color: whitesmoke">
                                                        
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                                                class="img-fluid rounded-3" alt="Cotton T-shirt">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <h6 class="text-black mb-0">{{ $item->product->name }}</h6>
                                                        </div>
                                                        <div
                                                            class="col-md-3 col-lg-3 col-xl-2 d-flex justify-content-center">
                                                            <p>Stok Habis</p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">

                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">

                                                            <button class="badge bg-danger delete-button"
                                                                data-item-id="{{ $item->id }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4">
                                                @endif
                                            @endforeach
                                        @endif
                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            @php
                                                $total = 0;
                                            @endphp

                                            @foreach ($user->cart->cartItems()->whereHas('product', function ($query) {
                                            $query->where('stock', '>', 0);
                                            })->get() as $item)
                                                @php
                                                    $total += $item->quantity * $item->product->price;
                                                @endphp
                                            @endforeach

                                            <h5>Rp{{ number_format($total, 0, ',', '.') }}</h5>
                                        </div>
                                        @endif
                                        <div class="row pt-5">
                                            <div class="col-6">
                                                <h6 class="mb-0"><a href="#!" class="text-body">
                                                    <i class="fa fa-long-arrow-alt-left me-2"></i>Back to shop</a>
                                                </h6>
                                            </div>
                                            @if ($user->cart->cartItems->isNotEmpty())
                                            <div class="col-6 text-end">
                                                <form method="get" action="{{ route('checkout') }}">
                                                    @csrf
                                                    
                                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                                    
                                                    <div id="hiddenInputsContainer"></div>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function handleCheckboxClick(checkbox) {
            var hiddenInputsContainer = document.getElementById('hiddenInputsContainer');
    
            // Create hidden input for the clicked checkbox
            if (checkbox.checked) {
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'carts[' + checkbox.value + ']';
                hiddenInput.value = checkbox.value;
                hiddenInputsContainer.appendChild(hiddenInput);
            } else {
                // If the checkbox is unchecked, remove the corresponding hidden input
                var hiddenInputToRemove = hiddenInputsContainer.querySelector('input[name="cart[' + checkbox.value + ']"]');
                if (hiddenInputToRemove) {
                    hiddenInputToRemove.parentNode.removeChild(hiddenInputToRemove);
                }
            }
        }
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


    <script>
        $('.delete-button').click(function() {
            var itemId = $(this).data('item-id');

            $.ajax({
                type: 'DELETE',
                url: '/cartItem/' + itemId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(reponse) {
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error deleting item', error);
                }
            });
        });
        $('.increment-button').click(function() {
            var itemId = $(this).data('item-id');

            $.ajax({
                type: 'PATCH',
                url: '/cartItem/increment/' + itemId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(reponse) {
                    window.location.reload();
                }
            });
        });
        $('.decrement-button').click(function() {
            var itemId = $(this).data('item-id');

            $.ajax({
                type: 'PATCH',
                url: '/cartItem/decrement/' + itemId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(reponse) {
                    window.location.reload();
                }
            });
        });
    </script>

@endsection
