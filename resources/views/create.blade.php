    @extends('main')

    @section('content')

        <div class="container">
            <div class="row mt-5">

                <div class="col col-5">
                    <div class="p-3">

                        {{-- alert after creating post (with return) --}}
                        @if (session('insertSuccess'))
                            <div class="alert-message">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> {{ session('insertSuccess')  }} </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        @if (session('updateSuccess'))
                            <div class="alert-message">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> {{ session('updateSuccess')  }} </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        {{-- Validation all error messages --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $err )
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="text-group mb-3">
                                <label for="">Post Title</label>
                                <input type="text" name="postTitle" class="form-control @error ('postTitle') is-invalid @enderror" placeholder="Enter title...." value={{ old('postTitle') }} >

                                @error('postTitle')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-group mb-3">
                                <label for="">Post Description</label>
                                <textarea name="postDescription" class="form-control @error ('postDescription') is-invalid @enderror " cols="30" rows="10" placeholder="Enter Description..">{{ old('postDescription') }}</textarea>

                                @error('postDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-group mb-3">
                                <label for="">Images </label>
                                <input type="file" name="postImage" class="form-control  @error ('postImage') is-invalid @enderror " value={{ old('postImage') }} >

                                @error('postImage')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-group mb-3">
                                <label for="">Fees </label>
                                <input type="number" name="postFees" class="form-control @error ('postFees') is-invalid @enderror " placeholder="Enter fees...." value={{ old('postFees') }} placeholder="Enter Rating....">

                                @error('postFees')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-group mb-3">
                                <label for="">Address </label>
                                <input type="text" name="postAddress" class="form-control @error ('postAddress') is-invalid @enderror " placeholder="Enter location...." value={{ old('postAddress') }} >

                                @error('postAddress')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-group mb-3">
                                <label for="">Rating </label>
                                <input type="number" min='0' max='5' name="postRating" class="form-control @error ('postRating') is-invalid @enderror"  value={{ old('postRating') }} >

                                @error('postRating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="submit" value="Create" class="btn btn-danger">
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col col-7">

                    <div class="row mb-3">
                        <div class="col-5 h3"> Total - {{ $posts->total() }} </div>

                        {{-- data searching --}}
                        <div class="col-5 offset-2">
                           <div class="d-flex">
                            <input type="text" name="" class="form-control" placeholder="Enter Search Key... ">
                            <button class="btn btn-outline-danger">
                                <i class="fa-solid fa-magnifying-glass"></i></button>
                           </div>
                        </div>
                    </div>

                    <div class="data-container">

                        @foreach ( $posts as $items )
                            <div class="blogpost p-3 shadow mb-3">
                                <div class="row">
                                    <div class="col-8"><h5>{{ $items ['title'] }} | {{ $items ['id'] }}</h5></div>
                                    <div class="col-3 offset-1">{{ $items ['created_at']->format("d/m/Y | n:i:A") }}</div>
                                </div>
                                {{-- <p class="text-muted">{{ $items ['description'] }}</p> --}}

                                {{-- remove string phrase/word --}}
                                <p class="text-muted">{{ Str::words($items ['description'],10,'.....') }}</p>

                                <span>
                                    <i class="fa-solid fa-dollar-sign text-success"></i> {{$items['price']}} kyats
                                </span> |

                                <span>
                                    <i class="fa-solid fa-house-circle-check text-danger"></i> {{ $items->address }}
                                </span> |

                                <span>
                                    {{ $items->rating }}<i class="fa-solid fa-star text-warning ms-1"></i>
                                 </span>

                                <div class="text-end">
                                   <a href="{{url('post/delete/' .$items['id']) }}">
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> ဖျက်ရန်</button>
                                   </a>

                                   <a href="{{ route ('post#update', $items['id']) }}">
                                    <button class="btn btn-sm btn-warning"><i class="fa-solid fa-circle-info"></i> အပြည့်အစုံဖတ်ရန်</button>
                                   </a>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- for pagniation  --}}
                    {{$posts ->links()}}
                </div>

            </div>
        </div>

    @endsection
