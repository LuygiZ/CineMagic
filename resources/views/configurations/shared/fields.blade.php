@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="ticketPrice" label="Ticket Price (€)" :readonly="$readonly"
            value="{{ old('ticketPrice', $configuration->ticket_price) }}"/>
        <x-field.input name="newCustomerDiscount" label="New Customer Discount (€)" :readonly="$readonly"
            value="{{ old('newCustomerDiscount', $configuration->registered_customer_ticket_discount) }}"/>
    </div>
</div>
