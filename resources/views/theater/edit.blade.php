@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@extends('layouts.main')

@section('header-title', 'Edit Theater')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theater.show', ['theater' => $theater]) }}"
                        text="Ver Detalhes"
                        type="info"/>
                    <form method="POST" action="{{ route('theater.destroy', ['theater' => $theater]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete Teather"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Theater "{{ $theater->name }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 mb-6">
                        Clique no botão "Guardar" para guardar as informações.
                    </p>
                </header>

                <form method="POST" action="{{ route('theater.update', ['theater' => $theater]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-wrap space-x-8">
                        <div class="grow mt-6 space-y-4">
                            <!-- Name Field -->
                            <x-field.input name="name" label="Nome" :readonly="$readonly"
                                value="{{ old('name', $theater->name) }}" class="block w-full"/>
                        </div>

                        <!-- Image Upload Field -->
                        <div class="pb-6 mt-6 w-full md:w-1/3 relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                            <input type="file" name="photo_filename" id="photo_filename" class="mt-2 p-2 border rounded w-full" accept="image/*" onchange="previewImage(event)" {{ $readonly ? 'disabled' : '' }}>
                            <div class="mt-4 relative">
                                <img id="imagePreview" src="{{ old('photo_filename') ? asset('storage/theater_photos/' . old('photo_filename')) : asset('storage/theater_photos/' . $theater->photo_filename) }}" alt="Image Preview" class="max-w-full max-h-72 h-auto object-contain rounded shadow-lg transition transform duration-500 hover:scale-105 {{ $theater->photo_filename || old('photo_filename') ? '' : 'hidden' }}">
                                @if ($mode === 'edit' && $theater->photo_filename)
                                    <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                        &times;
                                    </button>
                                @endif  
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Guardar" class="uppercase"/>
                        <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                  href="{{ route('theater.index') }}"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <form class="hidden" id="form_to_delete_photo"
          method="POST" action="#">
        @csrf
        @method('DELETE')
    </form>
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

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        preview.src = '';
        preview.classList.add('hidden');
        document.getElementById('photo_filename').value = '';
    }
</script>
@endsection
