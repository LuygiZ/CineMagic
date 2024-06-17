@extends('layouts.main')

@section('header-title', 'Purchases')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

        @if ($purchases)
            <table class="table-auto border-collapse m-auto">
                <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th class="px-4 py-2 text-center hidden lg:table-cell"></th>
                        <th class="px-4 py-2 text-center">Customer Name</th>
                        <th class="px-4 py-2 text-center">Payment Type</th>
                        <th class="px-4 py-2 text-center">Price</th>
                        <th class="px-4 py-2 text-center">Date</th>
                        <th class="px-4 py-2 text-center">Pdf Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                            <td class="px-4 py-2 text-left hidden lg:table-cell"></td>
                            <td class="px-4 py-2 text-left">{{ $purchase->customer_name }}</td>
                            <td class="px-4 py-2 text-center">{{ $purchase->payment_type }}</td>
                            <td class="px-4 py-2 text-right">{{ $purchase->total_price }}€</td>
                            <td class="px-4 py-2 text-right">{{ $purchase->date }}</td>

                            @if ($purchase->receipt_pdf_filename && $purchase->pdfExists($purchase->receipt_pdf_filename))
                                <th class="px-4 py-2">
                                    <a href="{{route('pdf.download',['pdfFilename' => 'Purchase'.$purchase->id.'.pdf'])}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor" class="size-6 mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                </th>
                            @else
                                <th class="px-4 py-2 text-center">---</th>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <h1 class="text-2xl">There are no registered purchases</h1>
        @endif

    </div>
</div>
@endsection
