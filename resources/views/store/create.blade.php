@extends('layouts.store')
@section('container')
<div class="row justify-content-center">
    <div class="col-11 shadow mt-3 p-5">       
                <form action="{{ route('store.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="email">Store Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required
                            autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <div class="mb-2 w-100">
                            <label class="text-muted" for="address">Store Address</label>
                        </div>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" required>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
       
            
        </div>
    </div>
</div>

@endsection