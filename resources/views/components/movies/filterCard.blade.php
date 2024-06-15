<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="title" label="Title" class="grow"
                    value="{{ $title }}"/>
                </div>
                <div class="flex space-x-3">
                    <x-field.select name="genre_code" label="Genre"
                    :options="$genres" value="{{ $genre_code }}"/>
                </div>
                <div>
                    <x-field.input name="year" label="Year" class="grow"
                    value="{{ $year }}"/>
                </div>
            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <x-button element="submit" type="dark" text="Filter"/>
                </div>
                <div>
                    <x-button element="a" type="light" text="Cancel" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
