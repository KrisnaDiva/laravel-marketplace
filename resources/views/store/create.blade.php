@extends('layouts.store')
@section('container')
    <div class="row justify-content-center">
        <div class="col-11 shadow mt-3 p-5">
            <form action="{{ route('store.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="email">Store Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row justify-content-center border border-dark mb-3" id="store_address">
                    <label class="mb-3 text-muted" for="store_address">Store Address</label>
                    <div class="col-11 ">
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="full_name">Your Name/Store</label>
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                                name="full_name" value="{{ old('full_name') }}" required autofocus>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="phone_number">Phone Number</label>
                            <input id="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="province_id">Province</label>
                            </div>
                            <select class="form-select @error('province_id') is-invalid @enderror" id="province_id"
                                name="province_id">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="city_id">City</label>
                            </div>
                            <select class="form-select @error('city_id') is-invalid @enderror" id="city_id"
                                name="city_id">
                                <option value="">Select City</option>
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="district">District</label>
                            <input id="district" type="text"
                                class="form-control @error('district') is-invalid @enderror" name="district"
                                value="{{ old('district') }}" required>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="zip">Zip Code</label>
                            <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror"
                                name="zip" value="{{ old('zip') }}" required>
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="street">Street Name</label>
                            <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                                name="street" value="{{ old('street') }}" required>
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="others">Others Detail</label>
                            <input id="others" type="text" class="form-control @error('others') is-invalid @enderror"
                                name="others" value="{{ old('others') }}">
                            @error('others')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100" type="submit">Create</button>
            </form>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle change event on province dropdown
        $('#province_id').on('change', function() {
            var provinceId = $(this).val();
            // Fetch cities based on selected province using AJAX
            $.ajax({
                url: '/get-cities/' + provinceId, // Replace with your route to fetch cities
                type: 'GET',
                success: function(data) {
                    // Clear existing options
                    $('#city_id').empty();
                    // Add default option
                    $('#city_id').append('<option value="0">Select City</option>');
                    // Add fetched cities
                    $.each(data, function(key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection
