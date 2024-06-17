@extends('layouts.main')

@section('header-title', 'Manage Genres')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-genres.filter-card
                resetUrl="{{ route('genre.index') }}"
                :filterAction="$filterAction"
                :name="$filterByName"
            />

            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('genre.create') }}"
                    text="Create a New Genre"
                    type="success"/>
            </div>

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-genres.table :genres="$allGenres"
                    :showView="false"
                    :showEdit="true"
                    :showDelete="true"/>
            </div>

            <div class="mt-4 px-5">
                {{ $allGenres->links() }}
            </div>
        </div>
    </div>
@endsection
