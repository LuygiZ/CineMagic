<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $purchases = Purchase::where('customer_id', $user->customer->id)
        ->orderBy('date','desc')
        ->get();

        return view('purchases.index', compact('purchases'));
    }

}
