<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Seat;
use App\Models\Screening;
use App\Models\Ticket;
use App\Models\Configuration;

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
        $selectedSeats = $request->input('check', []);

        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        $cart = session('cart');
        $screening = Screening::find($request->input('screening_id')); 
        $price = Configuration::getTicketPrice();

        foreach ($selectedSeats as $seatId => $value) {
            $seat = Seat::find($seatId);    
            
            if ($seat && !$seat->ocupado && $screening) {

                if ($this->ticketExists($cart, $seat->id, $screening->id)) {
                    continue;
                }

                $seat->lugar = $seat->row.$seat->seat_number;

                $ticket = new Ticket();
                $ticket->Seat = $seat;    
                $ticket->Screening = $screening;
                $ticket->price = $price;

                $cart[] = $ticket;
                session(['cart' => $cart]);
            }
        }
        
        return redirect()->route('cart.show');
    }
    
    private function ticketExists(array $cart, int $seatId, int $screeningId): bool
    {
        foreach ($cart as $cartItem) {
            if ($cartItem->Seat->id === $seatId && $cartItem->Screening->id === $screeningId) {
                return true;
            }
        }
        return false;
    }

    public function remove(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (!session()->has('cart')) {
            return redirect()->route('cart.show');
        }

        $ticket = $request->ticket;

        if (isset($cart[$ticket])) {
            unset($cart[$ticket]);
        }
        
        if (empty($cart)) {
            $this->destroy();
        } else {
            session(['cart' => $cart]);
        }
        
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
