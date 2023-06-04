@extends('main')

@section('content')

   <div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3 bg-light shadow-sm  py-3">
            <div class="my-3">
                <a href="{{route ('post#update', $post['id']) }}" class="text-decoration-none">
                    <i class="fa-solid fa-arrow-left"></i> back
                </a>
            </div>

            <form action="{{ route('post#dataupdate') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- <label for="">Post ID</label> --}}
                <input type="hidden" class="form-control mb-3" name="postID" value="{{ $post['id'] }}">

                <label> Post title</label>
                <input type="text" name="postTitle" class="form-control my-3 border-2 border-dark @error ('postTitle') is-invalid @enderror" value= "{{ old('postTitle', $post ['title'] )}}" placeholder="Enter the title..." >
                @error('postTitle')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror

                <label>Image</label>
                <div class="">
                    @if ($post['image'] == null)
                        <img src="{{ asset('404image.png') }}" class="img-thumbnail mt-4 shadow-sm">
                    @else
                        <img src="{{ asset('storage/'. $post['image']) }}" class="img-thumbnail mt-4 shadow-sm">
                    @endif
                </div>
                <input type="file" name="postImage" class="form-control my-3  @error ('postImage') is-invalid @enderror " value={{ old('postImage') }} >
                @error('postImage')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <label class="my-3"> Post Description</label>
                <textarea name="postDescription" cols="30" rows="10" class="form-control mb-3 border-2 border-dark @error ('postDescription') is-invalid @enderror" placeholder="Enter Decription....">{{ old ('postDescription', $post['description']) }}</textarea>
                @error('postDescription')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror

                <label class="">Fees</label>
                <input type="number" name="postFees" class="form-control my-3 border-2 border-dark" value= {{ old('postFees', $post ['price'] )}}>

                <label class=""> Address</label>
                <input type="text" name="postAddress" class="form-control my-3 border-2 border-dark" value= {{ old('postAddress', $post ['address'] )}} placeholder="Enter Address...">


                <label class=""> Rating</label>
                <input type="number" min='0' max='5' name="postRating" class="form-control my-3 border-2 border-dark" value={{ old('postRating', $post ['rating']) }} >

                <input type="submit" value="Update" class="btn btn-dark text-light mx-3 float-end">
            </form>
        </div>

    </div>


   </div>

@endsection
