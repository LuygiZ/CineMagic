@extends('layouts.main')

@section('header-title', 'Manage Users')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="#"
                        text="New"
                        type="success"/>
                    <x-button
                        href="#"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="#">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
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
