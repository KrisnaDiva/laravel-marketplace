@extends('layouts.app')
@section('wrapper')
@include('layouts.navbar')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
    <div class="container">
        @yield('container')
    </div>
@endsection