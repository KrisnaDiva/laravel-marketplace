@extends('layouts.store')
@section('container')
<div class="row justify-content-center">
    <div class="col-11 shadow mt-3 p-5">       
                <form action="{{ route('store.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="email">Store Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="" required
                            autofocus>
                    </div>
        
                    <div class="mb-3">
                        <div class="mb-2 w-100">
                            <label class="text-muted" for="address">Store Address</label>
                        </div>
                        <input id="address" type="text" class="form-control" name="address" required>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
       
            
        </div>
    </div>
</div>

@endsection