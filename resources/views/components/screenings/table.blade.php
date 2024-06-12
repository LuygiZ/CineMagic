<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center hidden lg:table-cell">Filme</th>
            <th class="px-2 py-2 text-center">Data</th>
            <th class="px-2 py-2 text-center">Sala</th>
            <th class="px-2 py-2 text-center">Hora de inicio</th>
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
        @foreach ($screenings as $screening)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $screening->movie->title }} </td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $screening->date }} </td>
                <td class="px-2 py-2 text-left">{{ $screening->theater->name }}</td>
                <td class="px-5 py-2 text-right hidden sm:table-cell">{{ $screening->start_time }}</td>
                @if($showView)
                    <td class="text-right">
                        <x-table.icon-show class="ps-3 px-2 inline-block"
                        href="#"/>
                    </td>
                @else

                @endif
                @if($showEdit)
                    <td  class="text-right">
                        <x-table.icon-edit class="px-2 inline-block"
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                    </td>
                @endif

                @if($showDelete)
                <td>
                    <form method="POST" action="{{ route('screenings.destroy', ['screening' => $screening]) }}">
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
