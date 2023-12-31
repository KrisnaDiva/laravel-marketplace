@extends('layouts.main')
@section('title', 'Profile')
@section('container')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @include('profile.partials.update-profile')
    @include('profile.partials.update-password')
@endsection
