@extends('layouts.main')

@section('header-title', 'Carrinho')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full max-w-4xl">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">O Carrinho está vazio</h3>
            @else
            <div class="mt-5">
                <h3 class="mb-4 text-2xl text-center">Confirmação do Carrinho de Compras</h3>
                <form action="{{ route('cart.buy') }}" method="post" class="space-y-6">
                    @csrf
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-full max-w-md">
                            <x-field.input name="name" label="Name" class="block w-full"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.input name="email" label="Email" class="block w-full"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.input name="nif" label="NIF" class="block w-full"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.select name="select" :options="$payments" label="Payment Method" class="block w-full"/>
                        </div>
                    </div>
                    <div class="flex justify-center mt-6">
                        <x-button element="submit" type="dark" text="Confirmar" class="px-6"/>
                    </div>
                </form>
            </div>
            @endempty
        </div>
    </div>
@endsection
