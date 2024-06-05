@extends('layouts.main')

@section('header-title', 'Carrinho')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">O Carrinho está vazio</h3>
            @else
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <h1>Tabela</h1>
            </div>
            <div class="mt-12">
                <div class="flex justify-between space-x-12 items-end">
                    <div>
                        <h3 class="mb-4 text-xl">Shopping Cart Confirmation </h3>
                        <form action="{{ route('cart.confirm') }}" method="post">
                            @csrf
                                <x-field.input name="student_number" label="Student Number" width="lg"
                                                :readonly="false"
                                                value="{{ old('student_number') }}"/>
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
