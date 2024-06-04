<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center hidden lg:table-cell"></th>
            <th class="px-2 py-2 text-center hidden lg:table-cell">Nome</th>
            <th class="px-2 py-2 text-center">Email</th>
            <th class="px-2 py-2 text-center">Tipo</th>
            <th class="px-2 py-2 text-center">Estado</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
                <th></th>
            @endif

        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            @php
                $photoPath = $user->photo_filename ? asset('storage/photos/' . $user->photo_filename) : Vite::asset('resources/img/photos/default.png');
            @endphp
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">
                    <img src="{{ $photoPath }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                </td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $user->name }} </td>
                <td class="px-2 py-2 text-left">{{ $user->email }}</td>
                <td class="px-2 py-2 text-left">{{ $user->getTipo() }}</td>
                <td class="px-5 py-2 text-right hidden sm:table-cell">{{ $user->getEstado() }}</td>
                @if($showView && ($user->type == "A" || $user->type == "E"))
                    <td class="text-right">
                        <x-table.icon-show class="ps-3 px-2 inline-block"
                        href="{{ route('manageUsers.show', ['user' => $user]) }}"/>
                    </td>
                @else
                    <td></td>
                @endif
                @if($showEdit && ($user->type == "A" || $user->type == "E"))
                    <td  class="text-right">
                        <x-table.icon-edit class="px-2 inline-block"
                        href="{{ route('manageUsers.edit', ['user' => $user]) }}"/>
                    </td>
                @else
                    <td></td>
                @endif
                @if($showDelete)
                <td class="text-right">
                    <form action="{{ route('user.updateBlocked', $user->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        @if($user->blocked == 0)
                        <button type="submit" name="blocked" value="1" class="border-0 bg-transparent p-0 m-0">
                            <svg class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </button>
                        @else
                        <button type="submit" name="blocked" value="0" class="border-0 bg-transparent p-0 m-0">
                            <svg class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                            </svg>
                        </button>
                        @endif
                    </form>
                </td>

                <td>
                    <form method="POST" action="{{ route('manageUsers.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="blocked" value="0" class="border-0 bg-transparent p-0 m-0">
                            <x-table.icon-delete class="px-2 inline-block" href="#"/>
                        </button>
                    </form>
                </td>

                @else
                    <td></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
