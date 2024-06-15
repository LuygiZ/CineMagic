<div {{ $attributes }}>
    <table class="table-auto border-collapse m-auto">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center hidden lg:table-cell">Movie</th>
            <th class="px-2 py-2 text-center">Date</th>
            <th class="px-2 py-2 text-center">Theater</th>
            <th class="px-2 py-2 text-center">Start Time</th>

            @if ($showControl)
                <th></th>
            @endif

            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
            @if($showSeats)
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

                @if ($showControl)
                <td class="text-right">
                    <a href="{{ route('screenings.control', ['screening' => $screening]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor" class="size-6 mx-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      </svg>
                    </a>
                </td>
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

                @if ($showSeats)
                <td>
                    <a href="{{ route('screenings.seats', ['screening' => $screening->id]) }}" class="px-4 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.1" stroke="currentColor" class="size-6 mx-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
