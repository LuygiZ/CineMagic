@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@extends('layouts.main')

@section('header-title', 'Edit Genre')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <form method="POST" action="{{ route('genre.destroy', ['genre' => $genre]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete Genre"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Genre "{{ $genre->name }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 mb-6">
                        Click on the button "Save" to update the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('genre.update', ['genre' => $genre]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap space-x-8">
                        <div class="grow mt-6 space-y-4">
                            <!-- Name Field -->
                            <x-field.input name="name" label="Nome" :readonly="$readonly"
                                value="{{ old('name', $genre->name) }}" class="block w-full"/>
                        </div>

                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Guardar" class="uppercase"/>
                        <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                  href="{{ route('genre.index') }}"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>


@endsection
