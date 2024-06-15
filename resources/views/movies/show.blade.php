@extends('layouts.main')

@section('header-title', 'Manage Movies')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        "{{ $movie->title }}"
                    </h2>
                </header>
                @include('movies.shared.fields', ['mode' => 'show'])
            </section>
            <div class="flex flex-wrap justify-end items-center gap-4 my-4">
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Edit Movie"
                        type="primary"/>
                    <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                    href="{{ route('movies.index') }}"/>
            </div>
        </div>

        @if ($allScreenings->total())
        <h1 class="text-center text-2xl my-5 text-gray-500">Sessions for the next 15 days</h1>

            <x-screenings.table :screenings="$allScreenings"
                :showView="false"
                :showEdit="false"
                :showDelete="false"
                :showSeats="true"
                :showControl="false"/>

            <div class="mt-4 w-xl mx-auto">
                {{ $allScreenings->links() }}
            </div>
        @else
            <h1 class="text-center text-2xl mt-5 text-gray-500">There are no screening sessions for the next 15 days</h1>
        @endif

    </div>
</div>
@endsection
