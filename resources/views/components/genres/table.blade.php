<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center hidden lg:table-cell">Name</th>
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($genres as $genre)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $genre->name }} </td>

                @if($showEdit)
                    <td  class="text-right">
                        <x-table.icon-edit class="px-2 inline-block"
                        href="{{ route('genre.edit', ['genre' => $genre]) }}"/>
                    </td>
                @endif

                @if($showDelete)
                <td>
                    <form method="POST" action="{{ route('genre.destroy', ['genre' => $genre]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="blocked" value="0" class="border-0 bg-transparent p-0 m-0">
                            <x-table.icon-delete class="px-2 inline-block" href="#"/>
                        </button>
                    </form>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
