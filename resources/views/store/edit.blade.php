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
                        <label class="mb-2 text-muted" for="address">Address</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{{ $store->address }}" required>
                        @error('address')
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

@endsection