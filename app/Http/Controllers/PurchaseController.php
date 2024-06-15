<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->type != "C" ){
            return redirect()->route('home.show');
        }

        $purchases = Purchase::where('customer_id', $user->customer->id)
        ->orderBy('date','desc')
        ->get();

        return view('purchases.index', compact('purchases'));
    }

}
