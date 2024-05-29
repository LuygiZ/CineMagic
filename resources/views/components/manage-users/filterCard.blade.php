<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="name" label="Nome" class="grow"
                    value="{{ $name }}"/>

                </div>
                <div class="flex space-x-3">
                    <x-field.select name="type" label="Tipo de Utilizador"
                    value="{{ $type }}"
                    :options="$types"/>
                    <x-field.select name="blocked" label="Estado da conta"
                    value="{{ $blocked }}"
                    :options="[null => 'Qualquer Estado', '0' => 'Ativo', '1' => 'Bloqueado']"/>
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

