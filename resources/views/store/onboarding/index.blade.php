@extends('layouts.store')
@section('container')
    <div class="row justify-content-center">
        <div class="col-11 shadow mt-3 text-center " style="height: 50vh">
            <h3 class="align-middle">Welcome to marketplace</h3>
            <a href="{{ route('store.create') }}" class="btn btn-primary">Register Now</a>
        </div>
    </div>
@endsection