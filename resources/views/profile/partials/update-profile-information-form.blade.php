<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

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

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        @if (Auth::user()->type == "C")
        <x-field.input name="nif" type="text" label="Nif" :readonly="$readonly"
            value="{{ old('nif', $user->customer->nif) }}"/>

        <x-field.select name="payment_type" label="Método de pagamento" :readonly="$readonly"
            :options="['VISA' => 'VISA', 'PAYPAL' => 'PAYPAL', 'MBWAY' => 'MBWAY', 'NONE' => 'Sem metodo de pagamento'] "
            defaultValue="{{ old('payment_type', $user->customer->payment_type ?? 'NONE') }}"/>
    @endif


        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
