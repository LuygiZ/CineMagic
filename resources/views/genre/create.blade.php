@extends('layouts.main')

@section('header-title', 'Create New Genre')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        New Genre
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Click on the button "Save" to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('genre.store') }}" class="space-y-6">
                    @csrf

                    <div class="flex flex-wrap space-x-8">
                        <div class="grow mt-6 space-y-4">
                            <x-field.input name="name" label="Name" value="{{ old('name') }}" class="block w-full"/>
                        </div>
                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

@endsection
