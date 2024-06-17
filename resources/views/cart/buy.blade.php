@extends('layouts.main')

@section('header-title', 'Carrinho')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full max-w-4xl">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">The cart it's empty</h3>
            @else
            <div class="mt-5">
                <h3 class="mb-4 text-2xl text-center">Confirmation of Tickets Cart</h3>
                <form action="{{ route('cart.store') }}" method="post" class="space-y-6">
                    @csrf
                    <x-field.input name="total_price" value="{{ $totalPrice }}" class="hidden"/>
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-full max-w-md">
                            <x-field.input name="customer_name" label="Name" class="block w-full" value="{{old('customer_name')}}"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.input name="customer_email" label="Email" class="block w-full" value="{{old('customer_email')}}"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.input name="nif" label="NIF" class="block w-full" value="{{old('nif')}}"/>
                        </div>
                        <div class="w-full max-w-md">
                            <x-field.select name="payment_type" id="payment_type" :options="$payments" value="{{old('payment_type')}}" label="Payment Method" class="block w-full"/>
                        </div>
                        <div class="w-full max-w-md" id="visa_ref_container">
                            <x-field.input name="visa_ref" id="visa_ref" label="Visa Payment Reference" class="block w-full" value="{{old('visa_ref')}}"/>
                        </div>
                        <div class="w-full max-w-md" id="cvc_ref_container">
                            <x-field.input name="cvc_ref" id="cvc_ref" label="CVC" class="block w-full" value="{{old('cvc_ref')}}"/>
                        </div>
                        <div class="w-full max-w-md" id="mbway_ref_container">
                            <x-field.input name="mbway_ref" id="mbway_ref" label="MBWay Payment Reference" class="block w-full" value="{{old('mbway_ref')}}"/>
                        </div>
                        <div class="w-full max-w-md" id="paypal_ref_container">
                            <x-field.input name="paypal_ref" id="paypal_ref" label="PayPal Payment Reference" class="block w-full" value="{{old('paypal_ref')}}"/>
                        </div>
                    </div>
                    <div class="flex justify-center mt-6">
                        <x-button element="submit" type="dark" text="Confirmar" class="px-6"/>
                    </div>
                </form>
            </div>
            @endempty
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentTypeSelect = document.getElementById('payment_type').querySelector('select');
            
            const paymentContainers = {
                'VISA': document.getElementById('visa_ref_container'),
                'CVC': document.getElementById('cvc_ref_container'),
                'MBWAY': document.getElementById('mbway_ref_container'),
                'PAYPAL': document.getElementById('paypal_ref_container')
            };

            const paymentInputs = {
                'VISA': document.getElementById('visa_ref'),
                'CVC': document.getElementById('cvc_ref'),
                'MBWAY': document.getElementById('mbway_ref'),
                'PAYPAL': document.getElementById('paypal_ref'),
            };

            function handlePaymentSelect() {
                const selectedPayment = paymentTypeSelect.value;

                Object.values(paymentContainers).forEach(container => {
                    container.classList.add('hidden');
                });

                switch(paymentTypeSelect.value){
                    case 'VISA':
                        console.log("unselect")
                        paymentContainers['VISA'].classList.remove('hidden');
                        paymentContainers['CVC'].classList.remove('hidden');
                        paymentInputs['VISA'].removeAttribute('disabled');
                        paymentInputs['CVC'].removeAttribute('disabled');
                        break;
                    case 'MBWAY':
                        paymentContainers['MBWAY'].classList.remove('hidden');
                        paymentContainers['MBWAY'].classList.remove('hidden');
                        break;
                    case 'PAYPAL':
                        paymentContainers['PAYPAL'].classList.remove('hidden');
                        paymentContainers['PAYPAL'].classList.remove('hidden');
                        break;
                    default:
                        break;
                };
            }
            
            paymentTypeSelect.addEventListener('change', handlePaymentSelect);

            handlePaymentSelect();
        });
    </script>
@endsection
