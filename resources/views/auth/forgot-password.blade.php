@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('container')
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
            <div class="text-center my-5">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
            </div>
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h1 class="fs-4 card-title fw-bold">Forgot Password</h1>
                </div>
                <div class="card-body p-4">
                    <small>Forgot your password? No problem. Just let us know your email address and we will email you a
                        password reset link that will allow you to choose a new one.</small>
                    @if (session()->has('status'))
                        <small class="text-success d-block mt-3">We have emailed your password reset link.</small>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" type="submit">Send Link</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer py-3 border-0">
                    <div class="text-center">
                        Remember your password? <a href={{ route('login') }} class="text-dark">Login</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5 text-muted">
                Copyright &copy; 2017-2021 &mdash; Your Company
            </div>
        </div>
    </div>
@endsection
