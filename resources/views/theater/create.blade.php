@extends('layouts.main')

@section('header-title', 'Criar Novo Teatro')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Novo Teatro
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Clique no botão "Salvar" para armazenar as informações.
                    </p>
                </header>

                <form method="POST" action="{{ route('theater.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="flex flex-wrap space-x-8">
                        <div class="grow mt-6 space-y-4">
                            <x-field.input name="name" label="Nome" value="{{ old('name') }}" class="block w-full"/>
                            <x-field.input name="rows" label="Número de Filas" type="number" value="{{ old('rows') }}" class="block w-full"/>
                            <x-field.input name="seats_per_row" label="Número de Assentos por Fila" type="number" value="{{ old('seats_per_row') }}" class="block w-full"/>
                        </div>

                        <div class="pb-6 mt-6 w-full md:w-1/3 relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                            <input type="file" name="photo_filename" id="photo_filename" class="mt-2 p-2 border rounded w-full" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-4 relative">
                                <img id="imagePreview" src="{{ old('photo_filename') ? asset('storage/theater_photos/' . old('photo_filename')) : '' }}" alt="Image Preview" class="max-w-full max-h-72 h-auto object-contain rounded shadow-lg transition transform duration-500 hover:scale-105 {{ old('photo_filename') ? '' : 'hidden' }}">
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Salvar Novo Teatro" class="uppercase"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const preview = document.getElementById('imagePreview');

        reader.onload = function() {
            if (reader.readyState === 2) {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
