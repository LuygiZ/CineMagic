<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Nome</th>
            <th class="px-2 py-2 text-left">Email</th>
            <th class="px-2 py-2 text-left">Tipo</th>
            <th class="px-2 py-2 text-right hidden sm:table-cell">Bloquedo</th>
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
                <td class="px-2 py-2 text-left">{{ $user->type }}</td>
                <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $user->blocked }}</td>
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('manageUsers.show', ['user' => $user]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="#"/>
                    </td>
                @endif
                @if($showDelete)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="#"/>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
