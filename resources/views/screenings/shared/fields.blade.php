@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">

        <x-field.input name="title" label="Nome do filme" :readonly="$readonly"
            value="{{ old('title', $screening->movie ? $screening->movie->title : '') }}" />

        <x-field.select name="theater_id" label="Sala" value="{{ old('theater_id', $screening->theater_id) }}"
            :options="$allTheaters" :readonly="$readonly" />

        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data:</label>
        <div class="relative max-w-sm">

            <input datepicker datepicker-autohide type="date" value="{{ old('date', $screening->date) }}"
                name="date"
                class="border-gray-300
                            @error('time')
                                border-red-500 dark:border-red-500
                            @else
                                border-gray-300 dark:border-gray-700
                            @enderror
                text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-5 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                @disabled($readonly)>
            @error('date')
                <div class="text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Hora:</label>
        <div class=" relative max-w-sm">
            <input type="time" id="time" name="time" value="{{ old('time', $screening->start_time) }}"
                class="border-gray-300
                            @error('time')
                                border-red-500 dark:border-red-500
                            @else
                                border-gray-300 dark:border-gray-700
                            @enderror
                    text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-5 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                @disabled($readonly)>
            @error('time')
                <div class="text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if ($mode == 'create')
            <x-field.input type="number" name="numDays" class="max-w-sm"
                label="Registar sessões nos proximos dias pela mesma hora (inserir numero de dias)" :readonly="$readonly" />
        @endif
    </div>

</div>
