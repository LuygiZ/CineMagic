@extends('layouts.main')

@section('header-title', 'Manage Screenings')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-screenings.filterCard
            filterAction="{{ route('screenings.index') }}"
            resetUrl="{{ route('screenings.index') }}"
            :alltheaters="$allTheaters"
            :theater="old('theater_id', $filterByTheater)"
            :movieName="old('movie_name', $filterByMovieName)"
            :date="old('screeningDate', $filterByDate)"
            class="mb-6"
        />

        <div class="flex items-center gap-4 mb-4">
            <x-button
                href="{{route('screenings.create')}}"
                text="Create New Screening"
                type="success"/>
            </div>
        <div class="font-base text-sm text-gray-700 dark:text-gray-30">
            <x-screenings.table :screenings="$allScreenings"
                :showView="false"
                :showEdit="true"
                :showDelete="true"/>
        </div>
        <div class="mt-4 px-5">
            {{ $allScreenings->links() }}
        </div>
    </div>
</div>


@endsection
