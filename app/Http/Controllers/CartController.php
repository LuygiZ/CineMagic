<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Seat;
use App\Models\Screening;
use App\Models\Ticket;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart');
        @debug($cart);
        return view('cart.show', compact('cart'));
    }

    public function add(Request $request): RedirectResponse
    {
        session()->forget('cart');
        $selectedSeats = $request->input('check', []);

        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        $cart = session('cart');

        $screening = Screening::find($request->input('screening_id')); 

        foreach ($selectedSeats as $seatId => $value) {
            $seat = Seat::find($seatId);    
            
            if ($seat && !$seat->ocupado && $screening) {
                $seat->lugar = $seat->row.$seat->seat_number;

                $ticket = new Ticket();
                $ticket->Seat = $seat;    
                $ticket->Screening = $screening;
                $ticket->price = 15;

                $cart[] = $ticket;
                session(['cart' => $cart]);
            }
        }
        
        return redirect()->route('cart.show');
    }
    
    public function remove(): RedirectResponse
    {
        return redirect()->route('cart.show');
    }

    public function confirm(): RedirectResponse
    {
        return redirect()->route('cart.show');
    }

    public function destroy(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }
}
