@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Nome" :readonly="$readonly"
            value="{{$user->name}}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
            value="{{$user->email}}"/>
        <x-field.select name="type" label="Tipo de utilizador" :readonly="$readonly"
            :options="['A' => 'Administrador', 'E' => 'Empregado', 'C' => 'Cliente']"
            defaultValue="{{$user->type}}"/>
            <x-field.checkbox name="blocked" label="Bloqueado" :readonly="$readonly"
            value="{{$user->blocked}}"/>
    </div>
    
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            width="md"
            :readonly="$readonly"
            deleteTitle="Apagar Foto"
            :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
            deleteForm="form_to_delete_photo"
            imageUrl="/storage/photos/{{$user->photo_filename}}"/>
    </div>
</div>
