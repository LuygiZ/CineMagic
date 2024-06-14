@extends('layouts.main')

@section('header-title', 'Carrinho')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">O Carrinho está vazio</h3>
            @else
            <div class="mt-5">
                <div class="flex justify-center items-end">
                    <div>
                        <h3 class="mb-4 text-xl">Shopping Cart Confirmation </h3>
                            <table class="table-auto border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                                        <th class="px-2 py-2 text-left hidden md:table-cell">Nome</th>
                                        <th class="px-2 py-2 text-right hidden md:table-cell">Lugar</th>
                                        <th class="px-2 py-2 text-right hidden md:table-cell">Teatro</th>
                                        <th class="px-2 py-2 text-right hidden md:table-cell">Preço</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($cart as $index => $cartItem)
                                    <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $cartItem['Screening']->movie->title }}</td>
                                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $cartItem['Seat']->lugar }}</td>
                                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $cartItem['Screening']->theater->name }}</td>
                                        <td class="px-2 py-2 text-right hidden md:table-cell">{{ $cartItem['price'] }}€</td>
                                        <td class="text-right hidden md:table-cell border-b-0">
                                            <form action="{{ route('cart.remove', ['ticket' => $index]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" name="delete">
                                                    <x-table.icon-delete/>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>    

                            <form action="{{ route('cart.confirm') }}" method="post">
                                @csrf
                                <x-button element="submit" type="dark" text="Confirm" class="mt-4"/>
                            </form>
                    </div>
                    <div>
                        <form action="{{ route('cart.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <x-button element="submit" type="danger" text="Limpar carrinho" class="mt-4"/>
                        </form>
                    </div>
                </div>
            </div>
            @endempty
        </div>
    </div>
@endsection
