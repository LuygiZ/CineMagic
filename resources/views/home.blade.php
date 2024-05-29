@extends('layouts.main')

@section('header-title', 'Home Page')

@section('main')
    <main>
        <div class="max-w-7xl mt-10 mx-auto px-4">
            <img src="{{ Vite::asset('resources/img/photos/carousel1.png') }}" alt="..." class="mx-auto w-full rounded-lg shadow-lg">

            <h1 class="text-4xl text-center mt-5 font-extrabold text-gray-800">Em cartaz</h1>

            <div class="flex flex-wrap justify-center mt-8 gap-8">
            @foreach ($movies->take(8) as $movie)
                    <div class="relative overflow-hidden rounded-lg shadow-lg transform transition duration-500 hover:scale-105 max-w-sm">
                        @php
                            $posterPath = $movie->poster_filename ? 'storage/app/public/posters/' . $movie->poster_filename : 'storage/app/public/posters/_no_poster_1.png';
                        @endphp
                        <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="block">
                            <img src="{{ Vite::asset($posterPath) }}" alt="..." class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="absolute bottom-0 left-0 p-5">
                                <h1 class="text-2xl font-bold text-white">{{ $movie->title }}</h1>
                                <p class="mt-2 text-sm text-gray-300">{{ $movie->genre_code }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
