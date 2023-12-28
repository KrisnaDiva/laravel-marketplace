<div class="row justify-content-center mb-3">
    <div class="col-xxl-7 col-xl-8 col-lg-8 col-md-10 col-sm-12">
        <div class="card border border-dark">
            <div class="card-header text-center">
                <h1 class="fs-4 card-title fw-bold">Profile Information</h1>
                <small>Update your account's profile information and email address.</small>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <br>
                        @if ($user->image)
                        <img src="{{ asset('storage/'.$user->image->url) }}" class="img-preview img-fluid rounded" style="width: 10%">
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
                            name="name" value="{{ $user->name }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $user->email }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="phone_number">Phone Number</label>
                        <input id="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror"
                            name="phone_number" value="{{ $user->phone_number }}" required>
                        @error('phone_number')
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
