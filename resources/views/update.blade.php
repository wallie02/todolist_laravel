@extends('main')

@section('content')

   <div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3">
            <div class="my-3">
                <a href="{{route ('post#home')}}" class="text-decoration-none">
                    <i class="fa-solid fa-arrow-left"></i> back
                </a>
            </div>

            <h3> {{ $post->title }}</h3>

            <div class="d-flex">
                <div class="btn btn-sm bg-dark text-white me-2 my-3"> <i class="fa-solid fa-dollar-sign text-success"></i> {{ $post->price }} kyats</div>
                <div class="btn btn-sm bg-dark text-white me-2 my-3"> <i class="fa-solid fa-house-circle-check text-danger"></i> {{ $post->address }}</div>
                <div class="btn btn-sm bg-dark text-white me-2 my-3">{{ $post->rating }} <i class="fa-solid fa-star text-warning ms-1"></i></div>
                <div class="btn btn-sm bg-dark text-white me-2 my-3"> <i class="fa-solid fa-calendar-week"></i> {{ $post->created_at->format('j-F-Y') }}</div>
                <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-regular fa-clock"></i>{{ $post->created_at->format('h:m:s-A')}}</div>
            </div>

            <div class="">
                @if ($post->image == null)
                    <img src="{{ asset('404image.png') }}" class="img-thumbnail my-4 shadow-sm">
                @else
                    <img src="{{ asset('storage/'. $post->image) }}" class="img-thumbnail my-4 shadow-sm">
                @endif
            </div>

            <p class="text-muted">{{ $post->description }}</p>

        </div>
    </div>

    <div class="row">
        <div class="col-3 offset-8">
            <a href="{{route('post#edit', $post->id) }}">
                <button class="btn btn-dark text-light px-3">Edit</button>
            </a>
        </div>
    </div>

   </div>

@endsection
