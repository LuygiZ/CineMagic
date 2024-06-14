@extends('layouts.main')

@section('header-title', 'Carrinho')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full max-w-4xl">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">O Carrinho está vazio</h3>
            @else
            <div class="mt-5">
                <h3 class="mb-4 text-2xl text-center">Carrinho de Compras</h3>
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Seat</th>
                            <th class="px-4 py-2 text-left">Theater</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($cart as $index => $cartItem)
                        <tr class="border-b border-gray-400 dark:border-gray-500">
                            <td class="px-4 py-2">{{ $cartItem['screening']->movie->title }}</td>
                            <td class="px-4 py-2">{{ $cartItem['seat']->lugar }}</td>
                            <td class="px-4 py-2">{{ $cartItem['screening']->theater->name }}</td>
                            <td class="px-4 py-2">{{ $cartItem['price'] }}€</td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('cart.remove', ['ticket' => $index]) }}" method="post" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                        <x-table.icon-delete/>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="px-4 py-2" colspan="3">Total</td>
                        <td class="px-4 py-2">{{ $totalPrice }}€</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-end mt-4 space-x-4">
                    <form action="{{ route('cart.buy') }}" method="get">
                        @csrf
                        <x-button element="submit" type="dark" text="Confirmar" class="px-6"/>
                    </form>
                    <form action="{{ route('cart.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <x-button element="submit" type="danger" text="Limpar carrinho" class="px-6"/>
                    </form>
                </div>
            </div>
            @endempty
        </div>
    </div>
@endsection
