@extends('layouts.main')

@section('header-title', 'Edit Configurations')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h1 class="text-2xl">CineMagic Tickets Price</h1>
        <form method="POST" action="{{ route('configurations.update') }}">
            @csrf
            @method('PUT')
            @include('configurations.shared.fields', ['mode' => 'edit'])
            <div class="flex mt-6">
                <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                href="{{ route('configurations.index') }}"/>
            </div>
        </form>
    </div>
</div>
@endsection
