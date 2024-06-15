@extends('layouts.main')

@section('header-title', 'Manage Theaters')

@section('main')
<div class="flex flex-col space-y-8">
    <div class="p-6 sm:p-10 bg-white dark:bg-gray-900 shadow-lg sm:rounded-lg">
        <div class="max-w-3xl mx-auto">
            <header>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Theater: "{{ $theater->name }}"
                </h2>
            </header>
            <section class="space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <p class="mt-2 text-lg text-gray-900 dark:text-gray-100">{{ $theater->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Rows</label>
                        <p class="mt-2 text-lg text-gray-900 dark:text-gray-100">{{ $theater->seats->unique('row')->count() }}</p>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Seats</label>
                    <p class="mt-2 text-lg text-gray-900 dark:text-gray-100">{{ $theater->seats->count() }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                    <div class="mt-2 w-full max-w-sm mx-auto">
                        @if ($theater->photo_filename)
                            <img src="{{ asset('storage/theater_photos/' . $theater->photo_filename) }}" alt="Theater Image" class="w-full h-auto rounded-lg shadow-lg transition transform duration-500 hover:scale-105">
                        @else
                            <p class="mt-2 text-gray-500 dark:text-gray-400">No Image Available</p>
                        @endif
                    </div>
                </div>
            </section>
            <div class="mt-8 flex justify-end items-center space-x-4">
                <x-button
                    href="{{ route('theater.edit', ['theater' => $theater]) }}"
                    text="Edit Theater"
                    type="primary"/>
                <x-button element="a" type="light" text="Cancel" class="uppercase"
                            href="{{ route('theater.index') }}"/>
            </div>
        </div>
    </div>
</div>
@endsection
