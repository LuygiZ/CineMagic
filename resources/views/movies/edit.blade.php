@extends('layouts.main')

@section('header-title', 'Edit Movie')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        <x-button
                            href="{{ route('movies.show', ['movie' => $movie]) }}"
                            text="Ver Detalhes"
                            type="info"/>
                        <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">

                            @csrf
                            @method('DELETE')
                            <x-button
                                element="submit"
                                text="Eliminar Filme"
                                type="danger"/>
                        </form>

                    </div>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Edit Movie "{{ $movie->title }}"
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click the "Save" button to save the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('movies.update', ['movie' => $movie]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('movies.shared.fields', ['mode' => 'edit'])
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Guardar" class="uppercase"/>
                            <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                        href="{{ url()->full() }}"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    <form class="hidden" id="form_to_delete_photo"
        method="POST" action="{{ route('movies.photo.destroy', ['movie' => $movie]) }}">
        @csrf
        @method('DELETE')
    </form>
    @endsection

