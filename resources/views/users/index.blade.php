@extends('layouts.main')

@section('header-title', 'Gerenciar Utilizadores')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-users.filterCard
            filterAction="{{ route('users.index') }}"
            resetUrl="{{ route('users.index') }}"
            :types="[null => 'Qualquer Tipo', 'A' => 'Administrador', 'E' => 'Empregado', 'C' => 'Cliente']"
            :type="old('type', $filterByType)"
            :blocked="old('blocked', $filterByBlocked)"
            :name="old('name', $filterByName)"
            class="mb-6"
        />

        <div class="flex items-center gap-4 mb-4">
            <x-button
                href="{{route('users.create')}}"
                text="Criar um novo utilizador"
                type="success"/>
            </div>
        <div class="font-base text-sm text-gray-700 dark:text-gray-30">
            <x-users.table :users="$allUsers"
                :showView="true"
                :showEdit="true"
                :showDelete="true"/>
        </div>
        <div class="mt-4 px-5">
            {{ $allUsers->links() }}
        </div>
    </div>
</div>
@endsection
