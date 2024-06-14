<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Seat;
use App\Models\Screening;
use App\Models\Ticket;
use App\Models\Configuration;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart');

        $totalPrice = 0;
        if (!empty($cart)) {
            foreach ($cart as $cartItem) {
                $totalPrice += $cartItem->price;
            }
        }
        $totalPrice = number_format($totalPrice, 2);

        @debug($cart);
        return view('cart.show', compact('cart', 'totalPrice'));
    }   

    public function buy(): View
    {
        $cart = session('cart');
        $payments = ['Paypal', 'MBWay', 'Credit Card', 'Debit Card'];
        return view('cart.buy', compact('cart', 'payments'));
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
                $ticket->seat = $seat;    
                $ticket->screening = $screening;
                $ticket->price = $price;
                $ticket->qrcode_url = Str::random(255);
                $ticket->screening_id = $screening->id;
                $ticket->seat_id = $seat->id;

                $cart[] = $ticket;
                session(['cart' => $cart]);
            }
        }
        
        return redirect()->route('cart.show');
    }
    
    private function ticketExists(array $cart, int $seatId, int $screeningId): bool
    {
        foreach ($cart as $cartItem) {
            if ($cartItem->seat->id === $seatId && $cartItem->screening->id === $screeningId) {
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
    
    public function purchase(): RedirectResponse
    {
        return redirect()->route('cart.show');
    }

    public function destroy(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }
}
