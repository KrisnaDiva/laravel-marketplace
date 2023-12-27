@extends('layouts.app')
@section('wrapper')
@include('layouts.navbar')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <div class="container">
        @yield('container')
    </div>
@endsection