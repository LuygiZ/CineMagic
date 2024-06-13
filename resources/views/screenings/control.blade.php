@extends('layouts.main')

@section('header-title', 'Controlar Sessão')

@section('main')

    <div class="flex justify-center">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <h1 class="text-2xl">Informações da Sessão</h1>
            @include('screenings.shared.fields', ['mode' => 'show'])

            @if (!session()->has('screeningIdToControl') || session('screeningIdToControl') == null)

            <form method="POST" action="{{ route('screenings.enableControl', $screening->id) }}">
                @csrf
                <x-button element="submit" class="mt-5" text="Inicial Controlo de sessão" type="success" />
            </form>

            @else
            <form method="POST" action="{{ route('screenings.disableControl', $screening->id) }}">
                @csrf
                <x-button element="submit" class="mt-5" text="Terminar Controlo de sessão" type="danger" />
            </form>
                <div class="mt-5">
                    <form method="POST" action="#">
                        @csrf
                        @method('GET')

                        <x-field.input name="ticketCode" label="Código do Bilhete"/>

                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Verificar Bilhete" class="uppercase" />
                        </div>
                    </form>
                </div>

                @if (isset($ticket))
                    @if ($ticket != null)
                        <div class="border p-5 mt-5">
                            <div class="mt-5 text-xl flex items-center  ">

                                <div class="p-5 ">
                                    <p class="text-center text-blue-800 font-bold text-xl">Informações do Bilhete</p>
                                    <p><strong>Filme:</strong> {{ $ticket->screening->movie->title }}</p>
                                    <p><strong>Data e hora:</strong> {{ $ticket->screening->date }} -
                                        {{ $ticket->screening->start_time }}</p>
                                    <p><strong>Preço:</strong> {{ $ticket->price }}€</p>
                                    <p><strong>Estado do Bilhete:</strong>
                                        <span
                                            style="color: white; background-color: {{ $ticket->status == 'valid' ? 'green' : 'red' }}; padding: 2px 5px; border-radius: 3px;">
                                            {{ $ticket->status == 'valid' ? 'Válido' : 'Inválido' }}
                                        </span>
                                    </p>

                                    <br>
                                    <p class="text-center text-blue-800 font-bold text-xl">Informações do Cliente</p>
                                    <p><strong>Nome:</strong> {{ $ticket?->purchase?->customer_name ?? ' ---' }}</p>
                                    <br>
                                    <p class="text-center text-blue-800 font-bold text-xl">Lugar</p>
                                    <p><strong>Linha do lugar:</strong> {{ $ticket->seat->row }}</p>
                                    <p><strong>Número do lugar:</strong> {{ $ticket->seat->seat_number }}</p>
                                </div>

                                <div>
                                    @if ($ticket?->purchase?->customer?->user?->photo_filename)
                                        <img src="/storage/photos/{{ Auth::user()->photo_filename }}"
                                            class="w-64 h-64 min-w-11 min-h-11 rounded-full">
                                    @else
                                        <img src=" {{ Vite::asset('resources/img/photos/default.png') }}"
                                            class="w-64 h-64 min-w-11 min-h-11 rounded-full">
                                    @endif
                                </div>

                            </div>

                            @if ($ticket->status == 'valid')
                                <div class="flex">
                                    <x-button href="#" text="Aceitar Bilhete" class="px-2" type="success" />
                            @endif
                            <x-button href="{{ route('screenings.control', [$screening->id]) }}" text="Cancelar" class="px-2" type="light" />

                        </div>
                    @else
                        <x-alert type="danger" class="mt-5">
                            Bilhete Não Encontrado
                        </x-alert>
                    @endif
                @endif
            @endif
        </div>
    </div>

    </div>

@endsection
