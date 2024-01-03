@extends('layouts.main')
@section('title', 'My Order')
@section('container')
    <ul class="nav nav-tabs nav-justified nav-underline">
        <li class="nav-item">
            <a class="nav-link {{ Route::is('order.hasPaid') ? 'active' : '' }}" href="{{ route('order.hasPaid') }}">Has
                Paid</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('order.hasntPaid') ? 'active' : '' }}"
                href="{{ route('order.hasntPaid') }}">Has'nt
                Paid</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('order.canceedl') ? 'active' : '' }}"
                href="{{ route('order.canceled') }}">Canceled</a>
        </li>
    </ul>
    @foreach ($orders as $order)
        <div class="row mt-3 shadow p-5">
            <div class="col-12">
                <div class="row ">
                    @if (Route::is('order.hasPaid'))
                        <div class="col-12 text-start">
                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                        </div>
                    @elseif(Route::is('order.hasntPaid'))
                        <div class="col-12 text-end">
                            <small class="text-muted" id="countdown">
                                Pay Before {{ $order->created_at->addDay()->format('d M Y H:i') }}
                            </small>
                            <script>
                                var targetTimestamp = {{ $order->created_at->addDay()->timestamp * 1000 }};
                            </script>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <span>{{ $order->store->name }}</span>
                </div>
                <hr>
                @if ($order->details)
                    @foreach ($order->details as $detail)
                        <div class="row mt-2">
                            <div class="col-1 ">
                                <img src="{{ asset('storage/' . $detail->productWithTrashed->images->first()->url) }}"
                                    class="img-fluid rounded-3 border border-dark"
                                    alt="{{ $detail->productWithTrashed->name }}" width="100%">
                            </div>
                            <div class="col-9 d-flex align-items-center">
                                <div class="row ">
                                    <div class="col-12">
                                        <span>{{ $detail->productWithTrashed->name }}</span>
                                    </div>
                                    <div class="col-12">
                                        <span>&times;{{ $detail->quantity }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 text-end">
                                <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @endif
                <div class="row text-end">
                    <div class="col-11">
                        <span>Total Order :</span>
                    </div>
                    <div class="col-1">
                        <span>Rp{{ number_format($order->details->sum('subtotal') + $order->shipping_cost, 0, ',', '.') }}</span>
                    </div>


                </div>
                @if (Route::is('order.hasntPaid'))
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <form action="{{ route('order.destroy', $order->id) }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger">Cancel</button>
                            </form>
                            <button class="btn btn-primary" id="pay-button{{ $order->id }}">Pay</button>
                        </div>
                    </div>
                    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
                    </script>
                    <script type="text/javascript">
                        var id = {{ $order->id }};
                        document.getElementById('pay-button' + id).onclick = function() {
                            // SnapToken acquired from previous step
                            snap.pay('{{ $order->snap_token }}', {
                                // Optional
                                onSuccess: function(result) {
                                    paymentSuccess(id);
                                    //   /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                },
                                // Optional
                                onPending: function(result) {
                                    /* You may add your own js here, this is just example */
                                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                },
                                // Optional
                                onError: function(result) {
                                    /* You may add your own js here, this is just example */
                                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                }
                            });
                        };
                    </script>
                @endif
                @if (Route::is('order.hasPaid'))
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $order->id }}">See Transaction Detail </button>
                            <a class="btn btn-danger" href="{{ route('order.userPrint', $order->id) }}">Print Transaction
                                Detail</a>
                        </div>
                    </div>
                    <div class="modal fade modal-lg" id="exampleModal{{ $order->id }}" width="100%">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Detail </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
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
                                            <div>{{ $order->addressWithTrashed->full_name }}</div>
                                            <div>{{ $order->addressWithTrashed->phone_number }}</div>
                                            <div>{{ $order->addressWithTrashed->street }}({{ $order->addressWithTrashed->others }})</div>
                                            <div>{{ $order->addressWithTrashed->district }}, {{ $order->addressWithTrashed->city->name }}</div>
                                            <div>{{ $order->addressWithTrashed->province->name }}</div>
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
                @endif
            </div>
        </div>
    @endforeach
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function paymentSuccess(orderId) {
            // Use jQuery for AJAX
            $.ajax({
                type: 'PATCH',
                url: '/payment-success/' + orderId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(reponse) {
                    window.location.href = '/my-order/hasPaid';
                },
                error: function(error) {
                    console.error('Error', error);
                }
            });
        }
    </script>
@endsection
