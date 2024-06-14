@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <!-- Name Field -->
        <x-field.input name="name" label="Nome" :readonly="$readonly"
            value="{{ old('name', $theater->name) }}"/>
    </div>

    <div class="pb-6">
        <!-- Photo Field -->
        <x-field.image
            name="poster_filename"
            width="md"
            :readonly="$readonly"
            deleteTitle="Apagar Foto"
            :deleteAllow="($mode == 'edit') && ($theater->poster_filename)"
            deleteForm="form_to_delete_photo"
            imageUrl="/storage/theater_photos/{{ $theater->poster_filename }}"/>
    </div>
</div>
