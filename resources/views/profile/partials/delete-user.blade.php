<div class="row justify-content-center mb-3">
    <div class="col-xxl-7 col-xl-8 col-lg-8 col-md-10 col-sm-12">
        <div class="card border border-dark">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Delete Account</h1>
                <small>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @method('delete')
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="password">Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" value=""
                            required autofocus>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button class="btn btn-danger" type="submit">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
