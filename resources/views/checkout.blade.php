@extends('layouts.main')
@section('title', 'Dashboard')
@section('container')
    <div class="row">

        <div class="col-12 shadow p-5">
            <div class="row mb-3">
                <h4 class="text-danger">Alamat Pengiriman</h4>
            </div>
            <div class="row">
                <div class="col-2">
                    <h5>Krisna Diva (089658554101)</h5>
                </div>
                <div class="col-8 d-flex ">
                    <p>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang, KOTA MEDAN - MEDAN
                        SELAYANG, SUMATERA UTARA, ID 20131</p>
                </div>
                <div class="col-2 d-flex justify-content-between">
                    <div>
                        <span class="border border-danger text-danger px-1">Main</span>
                    </div>
                    <div>
                        <button class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Ubah</button>
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
            @php
                $cartTotal = 0;
                $cartsTotal = 0;
                $totalCarts = 0;
            @endphp
            <div class="row">
                @foreach ($groupedCarts as $storeCarts)
                    @if (count($storeCarts) > 1)
                        <div class="row">
                            <hr>
                            <div class="col-12">
                                <span>{{ $storeCarts->first()->product->store->name }}</span>
                            </div>
                        </div>


                        @foreach ($storeCarts as $cart)
                            @php
                                $couriers = ['jne', 'tiki', 'pos'];
                                $ongkirResults = [];
                                $totalWeight = $storeCarts->sum(function ($cart) {
                                    return $cart->product->weight * $cart->quantity;
                                });
                                foreach ($couriers as $courier) {
                                    $responseCost = Http::withHeaders([
                                        'key' => 'c02b93cf40f1b5bc247494c12cae4148',
                                    ])->post('https://api.rajaongkir.com/starter/cost', [
                                        'origin' => $cart->product->store->address->city->id,
                                        'destination' => $user->addresses->where('isMain', 1)->first()->city->id,
                                        'weight' => $totalWeight,
                                        'courier' => $courier,
                                    ]);

                                    $content = json_decode($responseCost, false);
                                    $ongkirResults[$courier] = $content->rajaongkir->results;
                                }
                            @endphp
                            <div class="row mt-3 align-items-center">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('storage/' . $cart->product->images->first()->url) }}"
                                                class="img-fluid rounded-3" alt="{{ $cart->product->name }}">
                                        </div>
                                        <div class="col-10">
                                            <span>{{ Str::limit($cart->product->name, 50, '...') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($cart->product->price, 0, ',', '.') }}</span></div>
                                <div class="col-2 text-center"><span>{{ $cart->quantity }}</span></div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @php
                                $cartsTotal += $cart->product->price * $cart->quantity;

                            @endphp
                        @endforeach
                        <div class="row mt-3 align-items-center">
                            <hr>
                            <div class="col-1">
                                <label for="">Pesan:</label>
                            </div>
                            <div class="col-4 border-end border-dark">
                                <input type="text" name="" id="" class="form-control"
                                    placeholder="(Opsional) tinggalkan pesan ke penjual">
                            </div>
                            <div class="col-1">
                                <label for="">Pengiriman:</label>
                            </div>
                            <div class="col-4 border-end border-dark">
                                <select id="shippingOption{{ $cart->id }}" class="form-select"
                                    aria-label="Default select example">
                                    <option value="0">Open this select menu</option>
                                    @foreach ($ongkirResults as $results)
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
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 text-center">
                                <span id="shippingCost{{ $cart->id }}">-</span>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    var id = {{ $cart->id }};
                                    var cartTotal = {{ $cartsTotal }};

                                    function updateTotal(selectedOptionValue) {
                                        cartTotal -= parseInt($('#shippingOption' + id).data('previousValue')) || 0;
                                        cartTotal += parseInt(selectedOptionValue);

                                        // Update the displayed shipping cost and total
                                        $('#shippingCost' + id).text('Rp' + selectedOptionValue);
                                        $('#totalPayment' + id).text('Rp' + cartTotal);

                                        // Store the current selected option value for future reference
                                        $('#shippingOption' + id).data('previousValue', selectedOptionValue);
                                    }

                                    function updateTotalSum() {
                                        var sum = 0;
                                        $('[id^="totalPayment"]').each(function() {
                                            sum += parseInt($(this).text().replace('Rp', '').replace(',', '')) || 0;
                                        });

                                        // Update the displayed total sum
                                        $('#total').text('Rp' + sum);
                                    }

                                    // Call updateTotalSum initially to set the initial total sum

                                    // Handle change event of the select dropdown
                                    $('#shippingOption' + id).change(function() {
                                        // Get the selected option value
                                        var selectedOptionValue = $(this).val();

                                        // Update the total by adding the selected shipping option value
                                        updateTotal(selectedOptionValue);
                                        updateTotalSum();
                                    });
                                });
                            </script>
                        </div>
                        <div class="row my-3">
                            <hr>
                            <div class="col-10 text-end">
                                <span>Total Pesanan ({{ $storeCarts->sum('quantity') }} Produk) :</span>
                            </div>
                            <div class="col-2 text-center">
                                <span id="totalPayment{{ $cart->id }}"></span>
                                @php
                                    $totalCarts += $cartsTotal;
                                    $cartsTotal = 0;
                                @endphp
                            </div>

                        </div>
                    @else
                        @foreach ($storeCarts as $cart)
                            @php
                                $couriers = ['jne', 'tiki', 'pos'];
                                $ongkirResults = [];

                                foreach ($couriers as $courier) {
                                    $responseCost = Http::withHeaders([
                                        'key' => 'c02b93cf40f1b5bc247494c12cae4148',
                                    ])->post('https://api.rajaongkir.com/starter/cost', [
                                        'origin' => $cart->product->store->address->city->id,
                                        'destination' => $user->addresses->where('isMain', 1)->first()->city->id,
                                        'weight' => $cart->product->weight * $cart->quantity,
                                        'courier' => $courier,
                                    ]);

                                    $content = json_decode($responseCost, false);
                                    $ongkirResults[$courier] = $content->rajaongkir->results;
                                }
                            @endphp
                            <div class="row">
                                <hr>
                                <div class="col-12">
                                    <span>{{ $cart->product->store->name }}</span>
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('storage/' . $cart->product->images->first()->url) }}"
                                                class="img-fluid rounded-3" alt="{{ $cart->product->name }}">
                                        </div>
                                        <div class="col-10">
                                            <span>{{ Str::limit($cart->product->name, 50, '...') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($cart->product->price, 0, ',', '.') }}</span></div>
                                <div class="col-2 text-center"><span>{{ $cart->quantity }}</span></div>
                                <div class="col-2 text-center"><span>
                                        Rp{{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="row mt-3 align-items-center">
                                <hr>
                                <div class="col-1">
                                    <label for="">Pesan:</label>
                                </div>
                                <div class="col-4 border-end border-dark">
                                    <input type="text" name="" id="" class="form-control"
                                        placeholder="(Opsional) tinggalkan pesan ke penjual">
                                </div>
                                <div class="col-1">
                                    <label for="">Pengiriman:</label>
                                </div>
                                <div class="col-4 border-end border-dark">
                                    <select id="shippingOption{{ $cart->id }}" class="form-select"
                                        aria-label="Default select example">
                                        <option value="0">Open this select menu</option>
                                        @foreach ($ongkirResults as $results)
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
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 text-center">
                                    <span id="shippingCost{{ $cart->id }}">-</span>
                                </div>
                                @php
                                    $cartTotal += $cart->product->price * $cart->quantity;
                                @endphp
                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        var id = {{ $cart->id }};
                                        var cartTotal = {{ $cartTotal }};

                                        function updateTotal(selectedOptionValue) {
                                            cartTotal -= parseInt($('#shippingOption' + id).data('previousValue')) || 0;
                                            cartTotal += parseInt(selectedOptionValue);

                                            // Update the displayed shipping cost and total
                                            $('#shippingCost' + id).text('Rp' + selectedOptionValue);
                                            $('#totalPayment' + id).text('Rp' + cartTotal);

                                            // Store the current selected option value for future reference
                                            $('#shippingOption' + id).data('previousValue', selectedOptionValue);
                                        }

                                        function updateTotalSum() {
                                            var sum = 0;
                                            $('[id^="totalPayment"]').each(function() {
                                                sum += parseInt($(this).text().replace('Rp', '').replace(',', '')) || 0;
                                            });

                                            // Update the displayed total sum
                                            $('#total').text('Rp' + sum);
                                        }
                                        // Handle change event of the select dropdown
                                        $('#shippingOption' + id).change(function() {
                                            // Get the selected option value
                                            var selectedOptionValue = $(this).val();

                                            // Update the total by adding the selected shipping option value
                                            updateTotal(selectedOptionValue);
                                            updateTotalSum();
                                        });
                                    });
                                </script>
                            </div>
                            <div class="row my-3">
                                <hr>
                                <div class="col-10 text-end">
                                    <span>Total Pesanan ({{ $storeCarts->sum('quantity') }} Produk) :</span>
                                </div>
                                <div class="col-2 text-center">
                                    <span id="totalPayment{{ $cart->id }}"></span>
                                </div>
                            </div>
                            @php
                                $cartTotal = 0;
                            @endphp
                        @endforeach
                    @endif
                @endforeach
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
                    <button class="btn btn-primary w-100">Bayar</button>
                </div>
            </div>
        </div>
    </div>
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
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101 <span
                                            class="border border-danger text-danger px-1">Main</span></span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <input type="radio" class="form-check" name="address">
                                </div>
                                <div class="col-9">
                                    <span class="text-muted"><b>Krisna diva</b> | (+62) 89658444101</span>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button class="badge bg-primary">Ubah</button>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <span>Jalan Bunga Wijaya Kesuma II No.99 B, Padang Bulan Selayang Ii, Medan Selayang
                                        MEDAN SELAYANG, KOTA MEDAN, SUMATERA UTARA, ID, 20131</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <button class="btn btn-primary w-25">Tambah Alamat Baru</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection
