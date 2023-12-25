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
                                            <h6 class="mb-0 text-muted">{{ $user->cart->cartItems->count() }} Items</h6>
                                        </div>
                                        <hr class="my-4">
                                        @if ($user->cart->cartItems->isNotEmpty())
                                            @foreach ($cart_items as $item)
                                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                                        <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                                            class="img-fluid rounded-3" alt="Cotton T-shirt">
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                                        {{-- <h6 class="text-muted">Shirt</h6> --}}
                                                        <h6 class="text-black mb-0">{{ $item->product->name }}</h6>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                        {{-- onclick="this.parentNode.querySelector('input[type=number]').stepDown()" --}}
                                                        <button class="btn btn-link px-2 decrement-button"
                                                            data-item-id="{{ $item->id }}">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="form-control" id="quantity"
                                                            name="quantity" max="{{ $item->product->stock }}"
                                                            value="{{ $item->quantity }}" oninput="handleInputChange()">

                                                        {{-- onclick="this.parentNode.querySelector('input[type=number]').stepUp()"> --}}
                                                        <button class="btn btn-link px-2 increment-button"
                                                            data-item-id="{{ $item->id }}">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                        <h6 class="mb-0">Rp{{ number_format($item->price, 0, ',', '.') }}
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
                                            @endforeach
                                        @endif
                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5>Rp{{ number_format($user->cart->total_price, 0, ',', '.') }}</h5>
                                        </div>

                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="#!" class="text-body"><i
                                                        class="fa fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>

                                    </div>
                                </div>

                                {{-- <div class="col-lg-4 bg-grey">
                  <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                    <hr class="my-4">
  
                    <div class="d-flex justify-content-between mb-4">
                      <h5 class="text-uppercase">items 3</h5>
                      <h5>€ 132.00</h5>
                    </div>
  
                    <h5 class="text-uppercase mb-3">Shipping</h5>
  
                    <div class="mb-4 pb-2">
                      <select class="select">
                        <option value="1">Standard-Delivery- €5.00</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                      </select>
                    </div>
  
                    <h5 class="text-uppercase mb-3">Give code</h5>
  
                    <div class="mb-5">
                      <div class="form-outline">
                        <input type="text" id="form3Examplea2" class="form-control form-control-lg" />
                        <label class="form-label" for="form3Examplea2">Enter your code</label>
                      </div>
                    </div>
  
                    <hr class="my-4">
                    <button type="button" class="btn btn-dark btn-block btn-lg"
                      data-mdb-ripple-color="dark">Register</button>  
                  </div>
                </div> --}}
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function handleInputChange() {
            var inputElement = document.getElementById("quantity");
            var maxValue = parseInt(inputElement.max);

            if (inputElement.value > maxValue) {
                inputElement.value = maxValue;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


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
