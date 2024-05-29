<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="title" label="Nome" class="grow"
                    value="{{ $title }}"/>
                </div>
                <div class="flex space-x-3">
                    <x-field.select name="genre_code" label="Género"
                    :options="$genres" value="{{ $genre_code }}"/>
                </div>
                <div>
                    <x-field.input name="year" label="Ano" class="grow"
                    value="{{ $year }}"/>
                </div>
            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <x-button element="submit" type="dark" text="Filtrar"/>
                </div>
                <div>
                    <x-button element="a" type="light" text="Cancelar" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
