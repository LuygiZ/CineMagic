<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="name" label="Name" class="grow"
                    value="{{ $name }}"/>

                </div>
                <div class="flex space-x-3">
                    <x-field.select name="type" label="Type of User"
                    value="{{ $type }}"
                    :options="$types"/>
                    <x-field.select name="blocked" label="Account State"
                    value="{{ $blocked }}"
                    :options="[null => 'Any State', '0' => 'Active', '1' => 'Blocked']"/>
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

