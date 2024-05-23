@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{$user->name}}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
                        value="{{$user->email}}"/>
        <x-field.select name="type" label="Tipo de utilizador" :readonly="$readonly"
        :options="['A' => 'Administrador', 'E' => 'Empregado', 'C' => 'Cliente']"/>
    </div>
</div>
