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
                            text="Delete Theater"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Theater "{{ $theater->name }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 mb-6">
                        Click on the button "Save" to update the information.
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
                            <div class="mt-4 relative">
                                @if ($theater->photo_filename)
                                    <x-field.image
                                        name="photo_filename"
                                        width="md"
                                        :readonly="$readonly"
                                        deleteTitle="Delete Photo"
                                        :deleteAllow="($mode == 'edit') && ($theater->photo_filename)"
                                        deleteForm="form_to_delete_photo"
                                        imageUrl="/storage/theater_photos/{{$theater->photo_filename}}"/>
                                @else
                                    <x-field.image
                                        name="photo_filename"
                                        width="md"
                                        :readonly="$readonly"
                                        deleteTitle="Delete Photo"
                                        :deleteAllow="($mode == 'edit') && ($theater->photo_filename)"
                                        deleteForm="form_to_delete_photo"
                                        imageUrl="/storage/posters/_no_poster_1.png"/>
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
          method="POST" action="{{ route('theater.photo.destroy', ['theater' => $theater]) }}"">
        @csrf
        @method('DELETE')
    </form>
</div>

@endsection
