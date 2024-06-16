@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" :readonly="$readonly"
            value="{{ old('title', $movie->title) }}"/>
        <x-field.select name="genre_code" label="Genre" :readonly="$readonly"
            :options="$genres" value="{{ old('genre_code', $movie->genre_code) }}"/>
        <x-field.input name="year" label="Year" :readonly="$readonly"
            value="{{ old('year', $movie->year) }}"/>
        <div class="h-40 overflow-auto"> <!-- Add fixed height and overflow auto -->
            <x-field.textarea name="synopsis" label="Synopsis" :readonly="$readonly"
                value="{{ old('synopsis', $movie->synopsis) }}" class="resize-y"/>
        </div>
        <x-field.input name="trailer_url" label="Trailer URL" :readonly="$readonly"
            value="{{ old('trailer_url', $movie->trailer_url) }}"/>
    </div>

    <div class="pb-6">
        @if ($mode != "create")
            @if ($movie->poster_filename)
                <x-field.image
                    name="poster_filename"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Delete Photo"
                    :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
                    deleteForm="form_to_delete_photo"
                    imageUrl="/storage/posters/{{$movie->poster_filename}}"/>
            @else
                <x-field.image
                    name="poster_filename"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Delete Photo"
                    :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
                    deleteForm="form_to_delete_photo"
                    imageUrl="/storage/posters/_no_poster_1.png"/>

            @endif

        @else
            <x-field.image
                name="poster_filename"
                width="md"
                :readonly="$readonly"
                deleteTitle="Delete Photo"
                :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
                deleteForm="form_to_delete_photo"
                imageUrl="/storage/posters/_no_poster_1.png"/>

        @endif
    </div>

</div>
