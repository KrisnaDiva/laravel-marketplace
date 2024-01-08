@extends('layouts.main')
@section('title', 'Dashboard')
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
<form action="{{ route('order.buyNow') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12 shadow p-5">
            <div class="row mb-3">
                <h4 class="text-danger">Alamat Pengiriman</h4>
            </div>
            <div class="row">
                <div class="col-2">
                    <h5>{{ $mainAddress->full_name }} ({{ $mainAddress->phone_number }})</h5>
                </div>
                <div class="col-8 d-flex ">
                    <p>{{ $mainAddress->street }}, {{ $mainAddress->city->name }} - {{$mainAddress->district}}, {{ $mainAddress->province->name }}, ID {{ $mainAddress->zip }}</p>
                </div>
                <div class="col-2 d-flex justify-content-between">
                    <div>
                        <span class="border border-danger text-danger px-1">Main</span>
                    </div>
                    <div>
                        <button class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button">Ubah</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 shadow p-5 mt-3">
            <div class="row mb-3">
                <div class="col-6 ">
                    <span>Produk Dipesan</span>
                </div>
                <div class="col-2 text-center">
                    <span class="text-muted">Harga Satuan</span>
                </div>
                <div class="col-2 text-center">
                    <span class="text-muted">Jumlah</span>
                </div>
                <div class="col-2 text-center">
                    <span class="text-muted">Subtotal Produk</span>
                </div>
            </div>
            <div class="row">
                            @php
                                $couriers = ['jne', 'tiki', 'pos'];
                                $ongkirResults = [];
                                foreach ($couriers as $courier) {
                                    $responseCost = Http::withHeaders([
                                        'key' => 'c02b93cf40f1b5bc247494c12cae4148',
                                    ])->post('https://api.rajaongkir.com/starter/cost', [
                                        'origin' => $product->store->address->city->id,
                                        'destination' => $user->addresses->where('isMain', 1)->first()->city->id,
                                        'weight' => $product->weight * $quantity,
                                        'courier' => $courier,
                                    ]);
                                    $content = json_decode($responseCost, false);
                                    if (isset($content->rajaongkir->results)) {
                                        $ongkirResults[$courier] = $content->rajaongkir->results;
                                    } else {
                                        $ongkirResults[$courier]=null;            
                                    }
                                }
                            @endphp
                            <div class="row">
                                <hr>
                                <div class="col-12">
                                    <span>{{ $product->store->name }}</span>
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->url) : 'https://static.vecteezy.com/system/resources/previews/005/337/799/original/icon-image-not-found-free-vector.jpg' }}"
                                                class="img-fluid rounded-3" alt="{{ $product->name }}">
                                        </div>
                                        <div class="col-10">
                                            <span>{{ Str::limit($product->name, 50, '...') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($product->price, 0, ',', '.') }}</span></div>
                                <div class="col-2 text-center"><span>{{ $quantity }}</span></div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($product->price * $quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <hr>
                                <div class="col-5"></div>
                                <div class="col-1">
                                    <label for="">Pengiriman:</label>
                                </div>
                                <div class="col-4 border-end border-dark">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                                    <select id="shippingOption" class="form-select"
                                        aria-label="Default select example" name="shippingCost" onchange="calculateTotal()">
                                        <option value="0">Open this select menu</option>
                                        @foreach ($ongkirResults as $results)
                                        @if ($results)                                           
                                        @foreach ($results as $item)
                                            @foreach ($item->costs as $cost)
                                                @php
                                                    $optionValue = '';
                                                    $value = null;
                                                    if ($item->name == 'Jalur Nugraha Ekakurir (JNE)') {
                                                        $optionValue .= 'JNE';
                                                    } elseif ($item->name == 'Citra Van Titipan Kilat (TIKI)') {
                                                        $optionValue .= 'TIKI';
                                                    }
                                                    $optionValue .= $cost->service . ' ';
                                                    foreach ($cost->cost as $harga) {
                                                        $value = $harga->value;
                                                        $optionValue .= 'Rp' . $harga->value . ' (est: ' . str_replace(' HARI', '', $harga->etd) . ' Days)';
                                                    }
                                                @endphp
                                                <option class="mb-2" value="{{ $value }}">
                                                    {!! $optionValue !!}
                                                </option>
                                            @endforeach
                                        @endforeach
                                        @else
                                        <option value="0">No shipping</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 text-center">
                                    <span id="shipping-Cost">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <hr>
                                <div class="col-10 text-end">
                                    <span>Total Pesanan ({{ $quantity }} Produk) :</span>
                                </div>
                                <div class="col-2 text-center">
                                    <span id="totalPayment"></span>
                                </div>
                            </div>

            </div>
        </div>
        <div class="col-12 shadow p-5 my-5">
            <div class="row px-4">
                <div class="col-10 text-end">
                    <span>Total Pembayaran : </span>
                </div>
                <div class="col-2 text-center">
                    <span id="total"></span>
                </div>
            </div>
            <div class="row justify-content-end mt-5 px-5">
                <hr>
                <div class="col-2 me-4">
                    <button class="btn btn-primary w-100" onclick="checkShippingOption()">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</form>
    <!-- Modal -->
    <div class="modal fade modal-lg" id="exampleModal" width="100%">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Alamat Saya</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-3">
                        <form action="{{ route('address.setMainWithoutParam') }}" method="post"> 
                            @method('patch')
                            @csrf
                        @foreach ($addresses->sortByDesc('isMain') as $address)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address" @checked($address->isMain==1) value="{{ $address->id }}">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>{{ $address->full_name }}</b> | {{ $address->phone_number }} 
                                        @if ($address->isMain==1)
                                        <span class="border border-danger text-danger px-1">Main</span> 
                                        @endif
                                    </span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <a class="badge bg-primary" href="{{ route('address.edit',$address->id) }}">Ubah</a>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>{{ $address->street }}, {{ $address->city->name }} - {{$address->district}}, {{ $address->province->name }}, ID {{ $address->zip }}</span>
                                </div>
                            </div>
                            <hr>
                        </div> 
                        @endforeach
                        <a class="btn btn-primary w-25" href="{{ route('address.create') }}">Tambah Alamat Baru</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            var shippingOptionValue = $('#shippingOption').val();

            if (shippingOptionValue === '0') {
                e.preventDefault();
                alert('Silakan pilih opsi pengiriman sebelum melakukan pembayaran.');
            }
        });
    });
</script>

    <script>
        
        function calculateTotal() {
            var shippingOption = document.getElementById('shippingOption');
            var shippingCostElement = document.getElementById('shipping-Cost');
            var totalPaymentElement = document.getElementById('totalPayment');
            var totalElement = document.getElementById('total');
    
            // Check if a shipping option is selected
            if (shippingOption.value != 0) {
                // Update the shipping cost element
                shippingCostElement.innerText = 'Rp' + formatNumber(parseFloat(shippingOption.value));
                
                // Calculate total payment and update the total payment element
                var productSubtotal = parseFloat('{{ $product->price * $quantity }}');
                var shippingCost = parseFloat(shippingOption.value);
                var totalPayment = productSubtotal + shippingCost;
                totalPaymentElement.innerText = 'Rp' + formatNumber(totalPayment);
                
                // Update the total element
                totalElement.innerText = 'Rp' + formatNumber(totalPayment);
            } else {
                // Reset values if no shipping option is selected
                shippingCostElement.innerText = '-';
                totalPaymentElement.innerText = '-';
                totalElement.innerText = '-';
            }
        }
    
        // Function to format a number as currency (e.g., 191900 -> 191.900)
        function formatNumber(number) {
            return number.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,');
        }
    </script>
    
@endsection
