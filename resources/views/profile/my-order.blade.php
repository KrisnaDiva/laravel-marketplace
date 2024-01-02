@extends('layouts.main')
@section('title', 'My Order')
@section('container')
<ul class="nav nav-tabs nav-justified nav-underline">
    <li class="nav-item">
      <a class="nav-link {{ Route::is('order.hasPaid') ? 'active' :'' }}" href="{{ route('order.hasPaid') }}">Has Paid</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('order.hasntPaid') ? 'active' :'' }}" href="{{ route('order.hasntPaid') }}">Has'nt Paid</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('order.cancel') ? 'active' :'' }}" href="{{ route('order.cancel') }}">Canceled</a>
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
        </div><hr>
        @if ($order->details)           
        @foreach ($order->details as $detail)           
        <div class="row mt-2">
            <div class="col-1 ">
                <img src="{{ asset('storage/' . $detail->product->images->first()->url) }}"
                class="img-fluid rounded-3 border border-dark" alt="{{ $detail->product->name }}" width="100%">
            </div>
            <div class="col-9 d-flex align-items-center">
                <div class="row ">
                    <div class="col-12">
                        <span>{{ $detail->product->name }}</span>
                    </div>
                    <div class="col-12">
                        <span>&times;{{ $detail->quantity }}</span>
                    </div>
                </div>
            </div>
            <div class="col-2 text-end">
                <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
        </div><hr>
        @endforeach
        @endif
        <div class="row text-end">
            <div class="col-11">
                <span>Shipping Fee :</span>
            </div>
            <div class="col-1">
                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="col-11">
                <span>Total Order :</span>
            </div>
            <div class="col-1">
                <span>Rp{{ number_format($order->details->sum('subtotal')+$order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            
           
        </div>
        @if (Route::is('order.hasntPaid'))            
        <div class="row mt-4">
            <div class="col-12 text-end">
                <form action="{{ route('order.destroy',$order->id) }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger">Cancel</button>
                </form>
                <button class="btn btn-primary">Pay</button>
            </div>

        </div>
        @endif
    </div>
  </div>
  @endforeach

@endsection
