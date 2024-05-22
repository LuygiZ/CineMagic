@extends('layouts.main')

@section('header-title', 'Manage Users')

@section('main')
<div class="flex justify-center">
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="#"
                    text="Create a new course"
                    type="success"/>
            </div>
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-manageUsers.table :users="$allUsers"
                :showView="true"
                :showEdit="true"
                :showDelete="true"
                />
            </div>
            <div class="mt-4 px-5">
                {{ $allUsers->links() }}
            </div>
        </div>
    </div>
@endsection