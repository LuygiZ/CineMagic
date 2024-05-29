@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Nome" :readonly="$readonly"
            value="{{ old('title', $movie->title) }}"/>
        <x-field.select name="genre_code" label="Género" :readonly="$readonly"
            :options="$genres" value="{{ old('genre_code', $movie->genre_code) }}"/>
        <x-field.input name="year" label="Ano" :readonly="$readonly"
            value="{{ old('year', $movie->year) }}"/>
        <x-field.textarea name="synopsis" label="Sumário" :readonly="$readonly"
            value="{{ old('synopsis', $movie->synopsis) }}" class="resize-y"/> <!-- Remove fixed height -->
        <x-field.input name="trailer_url" label="Trailer URL" :readonly="$readonly"
            value="{{ old('trailer_url', $movie->trailer_url) }}"/>
    </div>
    
    <div class="pb-6">
        <x-field.image
            name="poster_filename"
            width="md"
            :readonly="$readonly"
            deleteTitle="Apagar Foto"
            :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
            deleteForm="form_to_delete_photo"
            imageUrl="/storage/posters/{{ $movie->poster_filename }}"/>
    </div>
</div>
