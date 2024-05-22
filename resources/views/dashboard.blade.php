@extends('layouts.main')

@section('header-title', 'Dashboard')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold my-6 text-center text-gray-900 dark:text-gray-100">Bem-vindo ao CineMagic</h2>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center">
                            <p class="text-lg mb-4">{{ __("You're logged in!") }}</p>
                            <p class="mb-8 text-center">Olá, <span class="font-semibold">{{ Auth::user()->name }}</span>! Estamos felizes em vê-lo de volta.</p>
                            <div class="flex space-x-4 mb-8">
                                <a href="{{ url('/profile') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                    Ver Perfil
                            </a>
                            </div>
                            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                Voltar à página inicial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
