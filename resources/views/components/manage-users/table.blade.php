<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center hidden lg:table-cell">Nome</th>
            <th class="px-2 py-2 text-center">Email</th>
            <th class="px-2 py-2 text-center">Tipo</th>
            <th class="px-2 py-2 text-center">Bloqueado</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $user->name }}</td>
                <td class="px-2 py-2 text-left">{{ $user->email }}</td>
                <td class="px-2 py-2 text-left">{{$user->getTipo()}}</td>
                <td class="px-5 py-2 text-right hidden sm:table-cell">{{ $user->getEstado() }}</td>
                @if($showView && ($user->type == "A" || $user->type == "E"))
                    <td class="text-right">
                        <x-table.icon-show class="ps-3 px-2 inline-block"
                        href="{{ route('manageUsers.show', ['user' => $user]) }}"/>
                    </td>
                @endif
                @if($showEdit && ($user->type == "A" || $user->type == "E"))
                    <td  class="text-right">
                        <x-table.icon-edit class="px-2 inline-block"
                        href="{{ route('manageUsers.edit', ['user' => $user]) }}"/>
                    </td>
                @endif
                @if($showDelete)
                    <td  class="text-right">
                        <x-table.icon-delete class="px-2 inline-block"
                        action="#"/>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
