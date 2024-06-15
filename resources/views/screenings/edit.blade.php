@extends('layouts.main')

@section('header-title', 'Editar Utilizador')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        <form method="POST" action="{{ route('screenings.destroy', ['screening' => $screening]) }}">
                            @csrf
                            @method('DELETE')
                            <x-button
                                element="submit"
                                text="Delete Session"
                                type="danger"/>
                        </form>
                    </div>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Edit Film session "{{ $screening->movie->title }}"
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click the "Save" button to save the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('screenings.update', ['screening' => $screening]) }}">
                        @csrf
                        @method('PUT')
                        @include('screenings.shared.fields', ['mode' => 'edit'])
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                            <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                        href="{{ route('screenings.index') }}"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    @endsection

