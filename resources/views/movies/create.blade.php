@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@extends('layouts.main')

@section('header-title', 'Novo Filme')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Novo Filme
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="flex flex-wrap space-x-8">
                        <div class="grow mt-6 space-y-4">
                            <x-field.input name="title" label="Nome" :readonly="$readonly"
                                value="{{ old('title', $movie->title) }}" class="block w-full"/>
                            <x-field.select name="genre_code" label="Género" :readonly="$readonly"
                                :options="$genres" :selected="old('genre_code', $movie->genre_code)" class="block w-full"/>
                            <x-field.input name="year" label="Ano" :readonly="$readonly"
                                value="{{ old('year', $movie->year) }}" class="block w-full"/>
                            <div class="h-40 overflow-auto"> <!-- Add scrolling to synopsis field -->
                                <x-field.textarea name="synopsis" label="Sumário" :readonly="$readonly"
                                    value="{{ old('synopsis', $movie->synopsis) }}" class="resize-y"/>
                            </div>
                            <x-field.input name="trailer_url" label="Trailer URL" :readonly="$readonly"
                                value="{{ old('trailer_url', $movie->trailer_url) }}" class="block w-full"/>
                        </div>

                        <div class="pb-6 mt-6 w-full md:w-1/3 relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Poster</label>
                            <input type="file" name="poster_filename" id="poster_filename" class="mt-2 p-2 border rounded w-full" accept="image/*" onchange="previewImage(event)" {{ $readonly ? 'disabled' : '' }}>
                            <div class="mt-4 relative">
                                <img id="imagePreview" src="{{ old('poster_filename') ? asset('storage/posters/' . old('poster_filename')) : asset('storage/posters/' . $movie->poster_filename) }}" alt="Image Preview" class="max-w-full max-h-72 h-auto object-contain rounded shadow-lg transition transform duration-500 hover:scale-105 {{ $movie->poster_filename || old('poster_filename') ? '' : 'hidden' }}">
                                @if ($mode === 'edit' && $movie->poster_filename)
                                    <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                        &times;
                                    </button>
                                @endif  
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Guardar novo Filme" class="uppercase"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const preview = document.getElementById('imagePreview');

        reader.onload = function() {
            if (reader.readyState === 2) {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        preview.src = '';
        preview.classList.add('hidden');
        document.getElementById('poster_filename').value = '';
    }
</script>
@endsection
