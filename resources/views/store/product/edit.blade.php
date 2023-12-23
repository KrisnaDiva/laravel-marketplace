@extends('layouts.store')
@section('container')
    <div class="row justify-content-center">
        <div class="col-11 shadow mt-3 p-5">
            <label for="image" class="mb-2 text-muted">Product Image</label>
            <div class="row">
                @foreach ($product->images as $image)
                <div class="col-3" style="position: relative">
                    <img src="{{ asset('storage/'.$image->url) }}" class="img-preview img-fluid rounded border border-dark">
                    <form action="{{ route('products.destroyImage',['product'=>$product->id,'image'=>$image->id]) }}" method="post">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border border-dark" style="position: absolute; top: 0;right: 0;">&times;</button>
                    </form>
                </div>
                @endforeach
            </div>

            <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data" id="my-form">
                @method('put')
                @csrf              
                <div class="multiple-uploader @error('image') border border-danger @enderror" id="multiple-uploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">click to upload images.</span>
                        <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                        <span class="mup-msg">Only images, pdf and psd files are allowed for upload</span>
                    </div>
                    
                </div>
                @error('image')
                    <p class="text-danger">
                           {{ $message }}
                    </p>
                @enderror
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="name">Product Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$product->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
    
                <div class="mb-3">
                    <div class="mb-2 w-100">
                        <label class="text-muted" for="category_id">Category</label>
                    </div>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                        <option value="0">Select Category</option>
                        @foreach ($categories as $category)            
                        <option value="{{ $category->id }}" @selected($product->category_id==$category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="email">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" required>{{ old('description',$product->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                
                <div class="mb-3">
                    <div class="mb-2 w-100">
                        <label class="text-muted" for="condition_id">Condition</label>
                    </div>
                    <select class="form-select @error('condition_id') is-invalid @enderror" id="condition_id" name="condition_id">
                        <option value="0">Select Condition</option>
                        @foreach ($conditions as $condition)            
                        <option value="{{ $condition->id }}" @selected($product->condition_id==$condition->id)>{{ $condition->name }}</option>
                        @endforeach
                    </select>
                    @error('condition_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>

                <div class="mb-3">
                    <label class="mb-2 text-muted" for="price">Price</label>
                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price',$product->price) }}" required>
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="stock">Stock</label>
                    <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock',$product->stock) }}" required>
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>

            </form>
        </div>
    </div>

 

    <script src="{{ asset('js/multiple-uploader.js') }}"></script>
    <script>
        let multipleUploader = new MultipleUploader('#multiple-uploader').init({
            maxUpload: 20-{!! json_encode(count($product->images)) !!}, // maximum number of uploaded images
            maxSize: 2, // in size in mb
            filesInpName: 'image', // input name sent to backend
            formSelector: '#my-form', // form selector
        });
    </script>
@endsection
