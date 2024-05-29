@extends('layouts.main')

@section('header-title', 'Manage Users')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('manageUsers.edit', ['user' => $user]) }}"
                        text="Editar User"
                        type="primary"/>
                    <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                    href="{{ route('manageUsers.index') }}"/>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{$user->getTipo()}} "{{ $user->name }}"
                    </h2>
                </header>
                @include('manageUsers.shared.fields', ['mode' => 'show'])
            </section>
        </div>
    </div>
</div>
@endsection
