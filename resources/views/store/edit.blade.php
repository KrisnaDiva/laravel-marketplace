@extends('layouts.store')
@section('container')
<div class="row justify-content-center mb-3">
    <div class="col-xxl-7 col-xl-8 col-lg-8 col-md-10 col-sm-12">
        <div class="card border border-dark">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Store Information</h1>
                <small>Update your store information.</small>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('store.update',$store->id) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <br>
                        @if ($store->image)
                        <img src="{{ asset('storage/'.$store->image->url) }}" class="img-preview img-fluid rounded" style="width: 10%">
                        @else
                       tidak ada gambar
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"  onchange="previewImage()">
                        @error('image')
                       <div class="invalid-feedback">
                         {{ $message }}
                       </div>
                       @enderror
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="name">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $store->name }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="description">Description</label>
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                            name="description" value="{{ $store->description }}" required>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <button class="btn btn-primary" type="submit">SAVE</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mb-3">
    <div class="col-xxl-7 col-xl-8 col-lg-8 col-md-10 col-sm-12">
        <div class="card border border-dark">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Store Address Information</h1>
                <small>Update your store address</small>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('store.updateAddress',$address->id) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="full_name">Full Name</label>
                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name',$address->full_name) }}" required autofocus>
                        @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="phone_number">Phone Number</label>
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number',$address->phone_number) }}" required >
                        @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <div class="mb-2 w-100">
                            <label class="text-muted" for="province_id">Province</label>
                        </div>
                        <select class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)            
                                <option value="{{ $province->id }}" @selected($province->id==$address->province_id)>{{ $province->name }}</option>
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
                        <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id">
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
                        <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district',$address->district) }}" required >
                        @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="zip">Zip Code</label>
                        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip',$address->zip) }}" required >
                        @error('zip')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="street">Street Name</label>
                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street',$address->street) }}" required >
                        @error('street')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="others">Others Detail</label>
                        <input id="others" type="text" class="form-control @error('others') is-invalid @enderror" name="others" value="{{ old('others',$address->others) }}">
                        @error('others')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(){
    const image=document.querySelector('#image');
    const imgPreview=document.querySelector('.img-preview');
    
    imgPreview.style.display='block';

    const oFReader=new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent){
      imgPreview.src=oFREvent.target.result; 
    }
}
 </script>
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
                    $('#city_id').append('<option value="">Select City</option>');
                    // Add fetched cities
                    $.each(data, function(key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // Auto-select city based on the current value in the address
                    var currentCityId = '{{ $address->city_id }}'; // Get the current city_id from the address
                    if (currentCityId) {
                        $('#city_id').val(currentCityId);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Trigger the change event on page load to auto-select city if province is pre-selected
        $('#province_id').trigger('change');
    });
</script>
@endsection