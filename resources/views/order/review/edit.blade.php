@extends('layouts.main')
@section('title', 'Review')
@section('link')
<link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('container')
    <div class="row justify-content-center">
        <div class="col-11 shadow mt-3 p-5">
            <label for="image" class="mb-2 text-muted">review Image</label>
            <div class="row">
                @foreach ($review->images as $image)
                <div class="col-3" style="position: relative">
                    <img src="{{ asset('storage/'.$image->url) }}" class="img-preview img-fluid rounded border border-dark">
                    <form action="{{ route('review.destroyImage',['orderDetail'=>$review->orderDetail->id,'image'=>$image->id]) }}" method="post">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border border-dark" style="position: absolute; top: 0;right: 0;">&times;</button>
                    </form>
                </div>
                @endforeach
            </div>

            <form action="{{ route('review.update',$review->orderDetail->id) }}" method="POST" enctype="multipart/form-data" id="my-form">
                @method('put')
                @csrf  
                @if ($review->images->count()<5)
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
                @endif            

    
                <div class="mb-3">
                    <div class="mb-2 w-100">
                        <label class="text-muted" for="rating_id">Rating</label>
                    </div>
                    <select class="form-select @error('rating_id') is-invalid @enderror" id="rating_id" name="rating_id">
                        <option value="0">Select rating</option>
                        @foreach ($ratings as $rating)            
                        <option value="{{ $rating->id }}" @selected($review->rating_id==$rating->id)>{{ $rating->value }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="email">comment</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment',$review->comment) }}</textarea>
                    @error('comment')
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

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/multiple-uploader.js') }}"></script>
    <script>
        let multipleUploader = new MultipleUploader('#multiple-uploader').init({
            maxUpload: 5-{!! json_encode(count($review->images)) !!},
            maxSize: 2, // in size in mb
            filesInpName: 'image', // input name sent to backend
            formSelector: '#my-form', // form selector
        });
    </script>
@endsection
