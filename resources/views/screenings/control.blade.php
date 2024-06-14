@extends('layouts.main')

@section('header-title', 'Controlar Sessão')

@section('main')

    <div class="flex justify-center ">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <h1 class="text-2xl">Informações da Sessão</h1>
            @include('screenings.shared.fields', ['mode' => 'show'])

            @if (!session()->has('screeningIdToControl') || session('screeningIdToControl') == null)

                <form method="POST" action="{{ route('screenings.changeControl', $screening->id) }}">
                    @csrf
                    <x-button element="submit" class="mt-5" text="Inicial Controlo de sessão" type="success" />
                </form>
            @else
                <form method="POST" action="{{ route('screenings.changeControl', $screening->id) }}">
                    @csrf
                    <x-button element="submit" class="mt-5" text="Terminar Controlo de sessão" type="danger" />
                </form>
                <div class="mt-5">
                    <form method="GET" action="{{ route('screenings.verifyTicket') }}">
                        @csrf
                        <x-field.input name="ticketCode" label="Código do Bilhete" />

                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" name="ticketCode" text="Verificar Bilhete"
                                class="uppercase" />
                        </div>
                    </form>
                </div>

                @isset($ticket)
                    @if (!is_int($ticket))
                        @if ($ticket->screening_id != $screening->id)
                        <x-alert type="danger" class="mt-5">
                            O bilhete não pertence a esta sessão!
                        </x-alert>
                        @endif

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

                            @if ($ticket->status == 'valid' && $ticket->screening_id == $screening->id)
                                <div class="flex">
                                    <form method="POST" action="{{ route('screenings.acceptTicket', ['screening' => $screening, 'ticket' => $ticket]) }}">
                                        @csrf
                                        <x-button element="submit" text="Aceitar Bilhete" class="px-2" type="success" />
                                    </form>

                            @endif
                            <x-button href="{{ route('screenings.control', [$screening->id]) }}" text="Cancelar" class="px-2"
                                type="light" />

                        </div>
                    @else
                        <x-alert type="danger" class="mt-5">
                            Bilhete Não Encontrado
                        </x-alert>
                    @endif
                @endisset
            @endif

        </div>
    </div>

    </div>

@endsection
