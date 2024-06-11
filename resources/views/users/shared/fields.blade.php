@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Nome" :readonly="$readonly"
            value="{{ old('name', $user->name) }}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
            value="{{ old('email', $user->email) }}"/>
        <x-field.select name="type" label="Tipo de utilizador" :readonly="$readonly"
            :options="['A' => 'Administrador', 'E' => 'Empregado', 'C' => 'Cliente']"
            defaultValue="{{ old('type', $user->type) }}"/>
        @if ($mode == "create")
        <x-field.input name="password" type="password" label="Password" :readonly="$readonly"
            value=""/>
        <x-field.input name="password_confirmation" type="password" label="Confirmar Password" :readonly="$readonly"
            value=""/>
        @endif

        <x-field.checkbox name="blocked" label="Bloqueado" :readonly="$readonly"
        value="{{$user->blocked}}"/>
    </div>

    <div class="pb-6">
        @if ($mode != "create")
            @if ($user->photo_filename)
                <x-field.image
                    name="photo_file"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Apagar Foto"
                    :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                    deleteForm="form_to_delete_photo"
                    imageUrl="/storage/photos/{{$user->photo_filename}}"/>
            @else
                <x-field.image
                    name="photo_file"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Apagar Foto"
                    :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                    deleteForm="form_to_delete_photo"
                    :imageUrl="Vite::asset('resources/img/photos/default.png')"/>
            @endif

        @else
            <x-field.image
                name="photo_file"
                width="md"
                :readonly="$readonly"
                deleteTitle="Apagar Foto"
                :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                deleteForm="form_to_delete_photo"
                :imageUrl="Vite::asset('resources/img/photos/default.png')"/>

        @endif
    </div>
</div>
