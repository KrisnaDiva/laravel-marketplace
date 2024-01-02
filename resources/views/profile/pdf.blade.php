<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="row text-center my-3">
    <h1 class="card-title fs-5">Transaction Detail</h1>                  
</div>
<div class="row justify-content-center p-1">
<div class="col-10">
    <div class="card">
        <div class="card-body">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between">
                    <span>No Invoice :</span>
                    <span>{{ $order->id }}</span>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <span>Purchase Date :</span>
                    <span>{{ $order->created_at->format('d F Y, H:i') }}</span>

                </div>
            </div>
            <hr>
            <div class="row p-1 justify-content-center">
                <div class="col-12 d-flex justify-content-between">
                    <h6>Product Details</h6>
                    <span>{{ $order->store->name }}</span>
                </div>
                @foreach ($order->details as $detail)
                    <div class="col-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <img src="{{ asset('storage/' . $detail->product->images->first()->url) }}"
                                            class="img-fluid rounded-3 border border-dark"
                                            alt="{{ $detail->productWithTrashed->name }}"
                                            width="100%">
                                    </div>
                                    <div class="col-7">
                                        <span>{{ $detail->product->name }}</span><br>
                                        <span>&times;{{ $detail->quantity }}</span>
                                    </div>
                                    <div class="col-3 text-end">
                                        <span>Total Price</span><br>
                                        <span
                                            class="fw-bold">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="row p-1 ">
                <div class="col-12">
                    <h6>Shipping Info</h6>
                </div>
                <div class="col-3">
                    <span>Address :</span>
                </div>
                <div class="col-9">
                    <div>{{ $order->address->full_name }}</div>
                    <div>{{ $order->address->phone_number }}</div>
                    <div>{{ $order->address->street }}({{ $order->address->others }})</div>
                    <div>{{ $order->address->district }}, {{ $order->address->city->name }}</div>
                    <div>{{ $order->address->province->name }}</div>
                </div>
            </div>
            <hr>
            <div class="row p-1">
                <div class="col-12">
                    <h6>Rincian Pembayaran</h6>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <span>Total Price ({{ $order->details->count() }} Product)</span>
                    <span><span>Rp{{ number_format($order->details->sum('subtotal'), 0, ',', '.') }}</span></span>
                </div>
                <div class="col-12 d-flex justify-content-between mb-3">
                    <span>Total Ongkos Kirim
                        ({{ $order->details->sum(function ($detail) {
                            return $detail->product->weight * $detail->quantity;
                        }) }}
                        gr)</span>
                    <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="col-12 d-flex justify-content-between">
                    <h6>Total Order</h6>
                    <h6>Rp{{ number_format($order->details->sum('subtotal') + $order->shipping_cost, 0, ',', '.') }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
