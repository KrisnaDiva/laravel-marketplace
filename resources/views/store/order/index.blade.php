@extends('layouts.store')
@section('container')
<ul class="nav nav-tabs nav-justified nav-underline">
    <li class="nav-item">
      <a class="nav-link {{ Route::is('order.index',1) ? 'active' :'' }}" href="{{ route('order.index',1) }}">Has Paid</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('order.index',0) ? 'active' :'' }}" href="{{ route('order.index',0) }}">Has'nt Paid</a>
    </li>
  </ul>
  <div class="row justify-content-center">
    <div class="col-10">
        <div class="card">
            <div class="card-header">
                Order
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp{{ number_format($order->details->sum('subtotal'), 0, ',', '.') }}</td>
                            <td class="d-flex">
                                <a href="" class="btn btn-success mx-2">show</a>
                            </td>
                          </tr>
                        @endforeach
                      
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>


@endsection
