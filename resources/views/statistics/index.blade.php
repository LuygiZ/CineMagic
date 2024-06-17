@extends('layouts.main')

@section('header-title', 'Statistics')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

        <div class="container mx-auto p-4">
            <h1 class="text-3xl text-center font-bold mb-4">CineMagic Statistics</h1>

            <div class="my-8">
                <h2 class="text-2xl font-bold mb-4">Sales By Month</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-white">
                                <th class="px-4 py-2">Month</th>
                                <th class="px-4 py-2">Tickets Sold</th>
                                <th class="px-4 py-2">Total Price (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesByMonth as $sale)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500 dark:text-white text-center">
                                    <td class="px-4 py-2">{{ isset($sale->month) ? $sale->month : 'From Always' }}</td>
                                    <td class="px-4 py-2">{{ $sale->tickets_sold }}</td>
                                    <td class="px-4 py-2">{{ $sale->total_sales }}€ </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="my-8">
                <h2 class="text-2xl font-bold mb-4">TOP - Sales By Film</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-white">
                                <th class="px-4 py-2">Movie</th>
                                <th class="px-4 py-2">Tickets Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesByMovie as $sale)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500 dark:text-white text-center">
                                    <td class="px-4 py-2">{{ $sale->title }}</td>
                                    <td class="px-4 py-2">{{ $sale->tickets_sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="my-8">
                <h2 class="text-2xl font-bold mb-4">TOP - Occupation by Film</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-white">
                                <th class="px-4 py-2">Movie</th>
                                <th class="px-4 py-2">Occupancy rate (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($occupancyByMovie as $occupancy)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500 dark:text-white text-center">
                                    <td class="px-4 py-2">{{ $occupancy->title }}</td>
                                    <td class="px-4 py-2">{{ $occupancy->occupancy_rate }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="my-8">
                <h2 class="text-2xl font-bold mb-4">TOP - Purchases By Client </h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-white">
                                <th class="px-4 py-2">Client</th>
                                <th class="px-4 py-2">Number of Purchases</th>
                                <th class="px-4 py-2">Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customerPurchases as $purchase)
                                <tr class="border-b border-b-gray-400 dark:border-b-gray-500 dark:text-white text-center">
                                    <td class="px-4 py-2">{{ $purchase->name }}</td>
                                    <td class="px-4 py-2">{{ $purchase->purchases }}</td>
                                    <td class="px-4 py-2">{{ $purchase->total_spent }}€</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
