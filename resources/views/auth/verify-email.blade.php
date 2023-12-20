@extends('layouts.auth')
@section('title', 'Verify Email')
@section('container')
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
            <div class="text-center my-5">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
            </div>
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h1 class="fs-4 card-title fw-bold">Verify Email</h1>
                </div>
                <div class="card-body p-4">
                    <small>Thanks for signing up! Before getting started, could you verify your email address by clicking on
                        the
                        link we just emailed to you? If you didn't receive the email, we will gladly send you
                        another.</small>
                    @if (session('status') == 'verification-link-sent')
                        <small class="text-success d-block mt-3">
                            A new verification link has been sent to the email address you provided during registration.
                        </small>
                    @endif
                    <div class="row mt-3">
                        <div class="col-8">
                            <form action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Resend Verification Email</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @method('delete')
                                @csrf
                                <div class="d-grid">
                                    <button class="btn btn-danger" type="submit">Logout</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="text-center mt-5 text-muted">
                Copyright &copy; 2017-2021 &mdash; Your Company
            </div>
        </div>
    </div>
@endsection
