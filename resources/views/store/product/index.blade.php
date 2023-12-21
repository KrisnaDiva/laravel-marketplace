@extends('layouts.store')
@section('container')
    <div class="row justify-content-center">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" style="width: 100%" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>          
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Products
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>
                                    @foreach ($product->images as $image)
                                    <img src="{{ asset('storage/'.$image->url) }}" alt="" width="10%">                                        
                                    @endforeach
                                </th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                              </tr>
                            @endforeach
                          
                        </tbody>
                      </table>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Create</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

@endsection
