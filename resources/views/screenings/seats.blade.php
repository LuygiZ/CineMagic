@extends('layouts.main')

@section('header-title', 'Introduction')

@section('main')
    <main>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg text-gray-900 dark:text-gray-100">
            <div class="max-full">
                <header>
                    <h2 class="text-lg font-medium text-center">
                        "{{ $screening->movie->title }}"
                    </h2>
                </header>
                
                <div class="content">
                    Data: {{ $screening->date }}<br>
                    Hora Inicio: {{ $screening->start_time }}

                    <br><br>
                    <div class="flex justify-center">
                        <div class="seats-selects w-10/12 max-full">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                @foreach ($seats as $seat)
                                    @if (!$seat->ocupado)
                                        <input type="checkbox" 
                                            class="peer hidden" 
                                            name="check[{{$seat->id}}]" 
                                            id="check{{$seat->id}}"/>
                                    @endif
                                @endforeach  

                                <input type="hidden" name="screening_id" value="{{ $screening->id }}">

                                <svg class="max-full" viewBox="0 0 900 1040" stroke="white">
                                    <g>
                                        @foreach ($seats as $seat)
                                        
                                            <path transform="translate({{ ($seat->seat_number-1) * 45 }}, {{ (ord($seat->row)-65) * 52 }})"
                                                id="seats[{{$seat->id}}]"
                                                class="peer-checked:fill-blue-600 seat relative {{!$seat->ocupado ? 'fill-black hover:fill-green-600 cursor-pointer' : 'fill-red-700' }} ease-in-out duration-300" 
                                                d="M14.046,9.268v-3.6S14.09,4.314,15.987,4H26.8a2.242,2.242,0,0,1,1.848,1.664,44.377,44.377,0,0,1,0,5.453,1.974,1.974,0,0,1-1.571,1.664H15.525S14,12.195,13.953,11.117Zm14.418,5.915s4.452,0.563,5.083,4.9,0,18.115,0,18.115-1.374.822-2.311,3.974c0,0-10.588-4.477-19.594.092A10.654,10.654,0,0,0,8.778,38.1L8.87,19.9s0.78-4.213,4.9-4.714S28.464,15.183,28.464,15.183ZM5.913,51.228L4.064,43.649s-0.7-3.481,1.664-4.529c0,0,3.088-.053,4.529,5.36a1.237,1.237,0,0,0,1.664,0s7.805-4.932,19.594.277a0.9,0.9,0,0,0,1.386-.647s0.345-4.6,3.7-4.991c0,0,2-.495,2.218,3.05a17.419,17.419,0,0,1-.555,3.789L36.782,51.32Z"
                                                data-seat-id="{{$seat->id}}"
                                                @if (!$seat->ocupado)
                                                    onclick="handleSeatClick(event)"
                                                    pointer-events="visiblePainted"
                                                @else
                                                    pointer-events="none"
                                                @endif>
                                                <title>{{$seat->lugar}}</title>
                                            </path>
                                            <text x="{{($seat->seat_number-1) * 45 + ($seat->seat_number >= 10 ? 11 : 14)}}" 
                                                y="{{ (ord($seat->row)-65) * 52 + 32}}" 
                                                class="text-xs text-center text-white" 
                                                style="pointer-events: none;">
                                                {{$seat->lugar}}
                                            </text>
                                        @endforeach     
                                    </g>
                                </svg>
                            
                                <x-button
                                    element="submit"
                                    text="Adicionar ao Carrinho"
                                    type="info"/>
                            </form> 

                        <script>
                                /*https://tailwindcss.com/docs/hover-focus-and-other-states
                                https://flowbite.com/docs/forms/checkbox/ */
                                
                                function handleSeatClick(event){
                                    const seatElement = event.target;
                                    const seatId = seatElement.getAttribute('data-seat-id');

                                    const checkboxId = 'check' + seatId;
                                    const checkbox = document.getElementById(checkboxId);

                                    if (!checkbox.checked) {
                                        seatElement.classList.remove('fill-black');
                                        seatElement.classList.add('fill-green-700');
                                        checkbox.checked = true;
                                    } else {
                                        seatElement.classList.remove('fill-green-700');
                                        seatElement.classList.add('fill-black');
                                        checkbox.checked = false;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
