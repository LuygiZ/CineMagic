@extends('layouts.main')

@section('header-title', 'Control Screening')

@section('main')

    <div class="flex justify-center ">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h1 class="text-2xl">Screening Information</h1>
            @include('screenings.shared.fields', ['mode' => 'show'])

            @if (!session()->has('screeningIdToControl') || session('screeningIdToControl') == null)

                <form method="POST" action="{{ route('screenings.changeControl', $screening->id) }}">
                    @csrf
                    <x-button element="submit" class="mt-5" text="Start Session Control" type="success" />
                </form>
            @else
                <form method="POST" action="{{ route('screenings.changeControl', $screening->id) }}">
                    @csrf
                    <x-button element="submit" class="mt-5" text="End Session Control" type="danger" />
                </form>
                <div class="mt-5">
                    <form method="GET" action="{{ route('screenings.verifyTicket') }}">
                        @csrf
                        <x-field.input name="ticketCode" label="Ticket Code" />

                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" name="ticketCode" text="Verify Ticket"
                                class="uppercase" />
                        </div>
                    </form>
                </div>

                @isset($ticket)
                    @if (!is_int($ticket))
                        @if ($ticket->screening_id != $screening->id)
                        <x-alert type="danger" class="mt-5">
                            The ticket does not belong to this session!
                        </x-alert>
                        @endif

                        <div class="border p-5 mt-5">
                            <div class="mt-5 text-xl flex items-center  ">


                                <div class="p-5 ">
                                    <p class="text-center text-blue-800 font-bold text-xl">Informações do Bilhete</p>
                                    <p><strong>Movie:</strong> {{ $ticket->screening->movie->title }}</p>
                                    <p><strong>Date and Time:</strong> {{ $ticket->screening->date }} -
                                        {{ $ticket->screening->start_time }}</p>
                                    <p><strong>Price:</strong> {{ $ticket->price }}€</p>
                                    <p><strong>Ticket State:</strong>
                                        <span
                                            style="color: white; background-color: {{ $ticket->status == 'valid' ? 'green' : 'red' }}; padding: 2px 5px; border-radius: 3px;">
                                            {{ $ticket->status == 'valid' ? 'Valid' : 'Invalid' }}
                                        </span>
                                    </p>

                                    <br>
                                    <p class="text-center text-blue-800 font-bold text-xl">Customer Information</p>
                                    <p><strong>Name:</strong> {{ $ticket?->purchase?->customer_name ?? ' ---' }}</p>
                                    <br>
                                    <p class="text-center text-blue-800 font-bold text-xl">Seat Information</p>
                                    <p><strong>Row:</strong> {{ $ticket->seat->row }}</p>
                                    <p><strong>Seat Number:</strong> {{ $ticket->seat->seat_number }}</p>
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
                            <x-button href="{{ route('screenings.control', [$screening->id]) }}" text="Cancel" class="px-2"
                                type="light" />

                        </div>
                    @else
                        <x-alert type="danger" class="mt-5">
                            Ticket Not Found
                        </x-alert>
                    @endif
                @endisset
            @endif

        </div>
    </div>

    </div>

@endsection
