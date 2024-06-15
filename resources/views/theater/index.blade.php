@extends('layouts.main')

@section('header-title', 'Manage Theaters')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-theaters.filter-card
                resetUrl="{{ route('theater.index') }}"
                :filterAction="$filterAction"
                :name="$filterByName"
            />

            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('theater.create') }}"
                    text="Create a New Theater"
                    type="success"/>
            </div>

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-theaters.table :theaters="$allTheaters"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"/>
            </div>

            <div class="mt-4 px-5">
                {{ $allTheaters->links() }}
            </div>
        </div>
    </div>
@endsection
