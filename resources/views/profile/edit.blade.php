@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@extends('layouts.main')

@section('header-title', 'Profile Edit')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl flex flex-col items-center justify-center">
                            <form method="POST" action="{{ route('manageUsers.updatePhoto', ['user' => $user]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @if ($user->photo_filename)
                                    <x-field.image
                                        name="photo_file"
                                        width="md"
                                        :readonly="$readonly"
                                        deleteTitle="Apagar Foto"
                                        :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                                        deleteForm="form_to_delete_photo"
                                        imageUrl="/storage/photos/{{$user->photo_filename}}"/>
                                @else
                                    <x-field.image
                                        name="photo_file"
                                        width="md"
                                        :readonly="$readonly"
                                        deleteTitle="Apagar Foto"
                                        :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                                        deleteForm="form_to_delete_photo"
                                        :imageUrl="Vite::asset('resources/img/photos/default.png')"/>
                                @endif
                                <x-button element="submit" type="dark" text="Guardar" class="mt-5"/>

                            </form>
                        </div>
                    </div>

                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <form class="hidden" id="form_to_delete_photo"
        method="POST" action="{{ route('manageUsers.photo.destroy', ['user' => $user]) }}">
        @csrf
        @method('DELETE')
    </form>

@endsection
