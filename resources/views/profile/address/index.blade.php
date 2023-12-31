@extends('layouts.main')
@section('title', 'Address')
@section('container')
<div class="row">
    <div class="col-8">
        @if (session()->has('success'))
            <div class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                <div id="successAlert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    $('#successAlert').alert('close');
                }, 5000);
            </script>
        @endif
        @if (session()->has('error'))
            <div class="position-fixed top-2 start-50 translate-middle-x" style="z-index: 1050;">
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    $('#successAlert').alert('close');
                }, 5000);
            </script>
        @endif
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between text-center">
                    <h2>My Addresses</h2>
                    <a href="{{ route('address.create') }}" class="btn btn-primary ">Create New Address</a>
                </div>
                <div class="card-body">
                    <h4>Address</h4>
                    @foreach ($user->addresses->sortByDesc('isMain') as $address)
                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <div class="row w-50">
                                    <div class="col-5 fw-bold">
                                        {{ $address->full_name }}

                                    </div>
                                    |
                                    <div class="col-5 text-muted">
                                        {{ $address->phone_number }}
                                    </div>

                                </div>
                                <p class="text-muted my-1">{{ $address->street }}
                                    @if ($address->others)
                                        ({{ $address->others }})
                                    @endif
                                </p>
                                <p class="text-muted">
                                    {{ $address->district }}, {{ $address->city->name }}, {{ $address->province->name }}, {{ $address->zip }}
                                </p>
                                @if ($address->isMain==1)
                                    <span class="border border-danger text-danger p-1">Main</span>
                                @endif
                            </div>
                            <div class="col-4 d-flex justify-content-end">
                                <div class="row justify-content-end">
                                    <div class="col-3 {{ $address->isMain==1 ? 'mx-5' : '' }}">
                                        <a href="{{ route('address.edit',$address->id) }}" class="btn btn-warning">Edit</a>

                                    </div>
                                    @if ($address->isMain==0)
                                    <div class="col-3 text-end">
                                        <form action="{{ route('address.destroy',$address->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                        </form>                                  
                                    </div>
                                    @endif
                                    @if ($address->isMain==0)
                                    <div class="col-6 text-end">
                                        <form action="{{ route('address.setMain',$address->id) }}" method="post">
                                        @method('patch')
                                        @csrf
                                        <button class="btn btn-success">Set as Main</button>
                                        </form>                                  
                                    </div>
                                    @endif
                                </div>
                               
                            </div>

                            
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
