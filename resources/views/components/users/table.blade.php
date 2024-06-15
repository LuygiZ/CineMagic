<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-center hidden lg:table-cell"></th>
                <th class="px-2 py-2 text-center hidden lg:table-cell">Name</th>
                <th class="px-2 py-2 text-center">Email</th>
                <th class="px-2 py-2 text-center">Type</th>
                <th class="px-2 py-2 text-center">State</th>
                @if ($showView)
                    <th></th>
                @endif
                @if ($showEdit)
                    <th></th>
                @endif
                @if ($showDelete)
                    <th></th>
                    <th></th>
                @endif

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @php
                    $photoPath = $user->photo_filename
                        ? asset('storage/photos/' . $user->photo_filename)
                        : Vite::asset('resources/img/photos/default.png');
                @endphp
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-2 py-2 text-left hidden lg:table-cell">
                        <img src="{{ $photoPath }}" alt="{{ $user->name }}"
                            class="w-10 h-10 rounded-full object-cover">
                    </td>
                    <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $user->name }} </td>
                    <td class="px-2 py-2 text-left">{{ $user->email }}</td>
                    <td class="px-2 py-2 text-left">{{ $user->getTipo() }}</td>
                    <td class="px-5 py-2 text-right hidden sm:table-cell">{{ $user->getEstado() }}</td>

                    @if ($showEdit && ($user->type == 'A' || $user->type == 'E'))
                        <td class="text-right">
                            <x-table.icon-edit class="ps-2 px-1 inline-block"
                                href="{{ route('users.edit', ['user' => $user]) }}" />
                        </td>
                    @else
                        <td></td>
                    @endif
                    @if ($showView)
                        <td class="text-right">
                            <x-table.icon-show class=" px-2 inline-block"
                                href="{{ route('users.show', ['user' => $user]) }}" />
                        </td>
                    @else
                        <td></td>
                    @endif
                    @if ($showDelete)
                        <td class="text-right">
                            <form action="{{ route('user.updateBlocked', $user->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                @if ($user->blocked == 0)
                                    <button type="submit" name="blocked" value="1"
                                        class="border-0 bg-transparent p-0 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                    </button>
                                @else
                                    <button type="submit" name="blocked" value="0"
                                        class="border-0 bg-transparent p-0 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>

                                    </button>
                                @endif
                            </form>
                        </td>

                        <td>
                            <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="blocked" value="0"
                                    class="border-0 bg-transparent p-0 m-0">
                                    <x-table.icon-delete class="px-2 inline-block" href="#" />
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
