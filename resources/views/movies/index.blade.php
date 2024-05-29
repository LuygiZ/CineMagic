@extends('layouts.main')

@section('header-title', 'Gerenciar Filmes')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-movies.filterCard
            filterAction="{{ route('movies.index') }}"
            resetUrl="{{ route('movies.index') }}"
            :genre_code="old('genre_code', $filterByGenre)"
            :year="old('year', $filterByYear)"
            :genres="$genres"
            title="old('title', $filterByTitle)"
            class="mb-6"
        />

        <div class="flex items-center gap-4 mb-4">
            <x-button
                href="{{route('movies.create')}}"
                text="Criar um novo filme"
                type="success"/>
            </div>
        <div class="font-base text-sm text-gray-700 dark:text-gray-30">
            <x-movies.table :movies="$allMovies"
                :showView="true"
                :showEdit="true"
                :showDelete="true"/>
        </div>
        <div class="mt-4 px-5">
            {{ $allMovies->links() }}
        </div>
    </div>
</div>
@endsection
