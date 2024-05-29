@extends('layouts.main')

@section('header-title', 'Gerenciar Filmes')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        "{{ $movie->title }}"
                    </h2>
                </header>
                @include('movies.shared.fields', ['mode' => 'show'])
            </section>
            <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Editar Filme"
                        type="primary"/>
                    <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                    href="{{ route('movies.index') }}"/>
                </div>
        </div>
    </div>
</div>
@endsection
