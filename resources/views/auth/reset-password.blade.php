@extends('layouts.auth')
@section('title', 'Reset Password')
@section('container')
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
            <div class="text-center my-5">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
            </div>
            @if ($errors->has('tokenError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h1 class="fs-4 card-title fw-bold">Reset Password</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('password.update') }}" method="POST">
                        @method('patch')
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input id="email" type="hidden" class="form-control" name="email"
                            value="{{ $request->email }}">
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="password">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" value=""
                                required autofocus>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                            <div class="invalid-feedback">
                                Password is required
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-5 text-muted">
                Copyright &copy; 2017-2021 &mdash; Your Company
            </div>
        </div>
    </div>
@endsection
