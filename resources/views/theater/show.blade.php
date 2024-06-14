@extends('layouts.main')

@section('header-title', 'Gerenciar Teatros')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        "{{ $theater->name }}"
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $theater->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                        @if ($theater->photo_filename)
                            <img src="{{ asset('storage/theater_photos/' . $theater->photo_filename) }}" alt="Teatro Image" class="mt-2 max-w-full h-auto object-contain rounded shadow-lg transition transform duration-500 hover:scale-105">
                        @else
                            <p class="mt-2 text-gray-500 dark:text-gray-400">No Image Available</p>
                        @endif
                    </div>
                </div>
            </section>
            <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                <x-button
                    href="{{ route('theater.edit', ['theater' => $theater]) }}"
                    text="Editar Teatro"
                    type="primary"/>
                <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                            href="{{ route('theater.index') }}"/>
            </div>
        </div>
    </div>
</div>
@endsection
