@extends('layouts.main')

@section('header-title', 'Introduction')

@section('main')
    <main>


        <div class="max-w-7xl mt-10 mx-auto">
            <img src="{{ Vite::asset('resources/img/photos/carousel1.png') }}" alt="..." class="mx-auto w-full ">

            <h1 class="text-4xl text-center mt-5">Em cartaz</h1>

            <div class="flex flex-row flex-wrap justify-evenly my-">
                @foreach ($movies->take(8) as $movie)
                    <div class="relative overflow-hidden rounded-lg mt-8 max-w-72 mx-3 sm-mx-5">
                        <img src="{{ Vite::asset('storage/app/public/posters/' . $movie->poster_filename) }}" alt="..."
                            class="w-full">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                        <h1 class="absolute bottom-10 left-5 text-3xl font-bold text-white">{{ $movie->title }}</h1>
                        <div class="absolute bottom-5 left-5 overflow-hidden text-xs leading-4 text-gray-300">{{ $movie->genre_code }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </main>
@endsection
