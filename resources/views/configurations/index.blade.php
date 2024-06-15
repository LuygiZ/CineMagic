@extends('layouts.main')

@section('header-title', 'Configurations')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h1 class="text-2xl">CineMagic Tickets Price</h1>
        @include('configurations.shared.fields', ['mode' => 'show'])
        <x-button
            href="{{ route('configurations.edit') }}"
            text="Edit Configurations"
            type="primary"
            class="mt-5"/>
    </div>
</div>
@endsection
