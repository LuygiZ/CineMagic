<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', null);
        return view('cart.show', compact('cart'));
    }
}
