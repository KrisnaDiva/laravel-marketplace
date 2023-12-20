<div class="row justify-content-center mb-3">
    <div class="col-xxl-7 col-xl-8 col-lg-8 col-md-10 col-sm-12">
        <div class="card border border-dark">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Reset Password</h1>
                <small>Ensure your account is using a long, random password to stay secure.</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('password.update') }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="current_password">Current Password</label>
                        <input id="current_password" type="password"
                            class="form-control @error('current_password') is-invalid @enderror" name="current_password" value=""
                            required autofocus>
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
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
                    <button class="btn btn-primary" type="submit">SAVE</button>
                </form>
            </div>
        </div>
    </div>
</div>
