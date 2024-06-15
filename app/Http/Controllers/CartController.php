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
use App\Models\Purchase;
use App\Http\Requests\PurchaseFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart');
        $totalPrice = 0;

        if (!empty($cart)) {
            $totalPrice = $this->getTotalPrice($cart);
        }

        return view('cart.show', compact('cart', 'totalPrice'));
    }

    public function buy(): View | RedirectResponse
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.show');
        }

        $cart = session('cart');

        if (empty($cart)) {
            return redirect()->route('cart.show');
        }

        $totalPrice = $this->getTotalPrice($cart);

        $payments = ['PAYPAL' => 'Paypal', 'MBWAY' => 'MBWay', 'VISA' => 'VISA'];

        return view('cart.buy', compact('cart', 'payments', 'totalPrice'));
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
                $ticket->qrcode_url = Str::random(50);
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

    private function getTotalPrice(array $cart){
        $totalPrice = 0;
        if (!empty($cart)) {
            foreach ($cart as $cartItem) {
                $totalPrice += $cartItem->price;
            }
        }

        return number_format($totalPrice, 2);
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

    public function store(PurchaseFormRequest $request): RedirectResponse
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.show');
        }

        $validatedData = $request->validated();
        $validatedData['date'] = date('Y-m-d');

        $cart = session('cart');

        $newPurchase = Purchase::create($validatedData);
        $newPurchase->customer_id = Auth::user()->customer->id;
        $newPurchase->save();

        foreach($cart as $cartItem) {
            unset($cartItem->seat);
            unset($cartItem->screening);
            $cartItem->status = "valid";
            $cartItem->purchase_id = $newPurchase->id;
            $cartItem->save();
        }


        return redirect()->route('pdf.generatePdf', [
            'purchase' => $newPurchase->id,
        ]);
    }

    public function destroy(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }
}
