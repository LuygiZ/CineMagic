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
        if(empty(Auth::user()->customer->purchases)){
            $price-=Configuration::getTicketDiscount();
        }

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

    public function store(PurchaseFormRequest $request)
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.show');
        }

        $validatedData = $request->validated();
        $validatedData['date'] = date('Y-m-d');

        switch($validatedData['payment_type']){
            case 'VISA':
                if(!Payment::payWithVisa($validatedData['visa_ref'], $validatedData['cvc_ref'])){
                    return redirect()->route('cart.buy')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', 'Payment with Visa failed');
                }

                $validatedData['payment_ref'] = $validatedData['visa_ref'];
                break;
            case 'MBWAY':
                if(!Payment::payWithMBway($validatedData['mbway_ref'])){
                    return redirect()->route('cart.buy')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', 'Payment with MBWay failed');
                }

                $validatedData['payment_ref'] = $validatedData['mbway_ref'];
                break;
            case 'PAYPAL':
                if(!Payment::payWithPaypal($validatedData['paypal_ref'])){
                    return redirect()->route('cart.buy')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', 'Payment with PayPal failed');
                }

                $validatedData['payment_ref'] = $validatedData['paypal_ref'];
                break;
            default: 
                return redirect()->route('cart.show')
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'That payment type is not allowed');
        }

        unset($validatedData['paypal_ref']);
        unset($validatedData['mbway_ref']);
        unset($validatedData['visa_ref']);

        $cart = session('cart');

        if(Auth::user()->type != "C"){
            return redirect()->route('cart.show')
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Only customers can make purchases! Please register with a customer account');
        }

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

        return $this->generatePdf($newPurchase);
    }

    public function destroy(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }

    public function generatePdf($purchase)
    {
        $data = [
            'title' => "CineMagic",
            'date' => date('m/d/Y'),
            'tickets' => session('cart'),
            'purchase' => $purchase
        ];

        $pdfName = "Purchase".$purchase->id.".pdf";

        $pdf = Pdf::loadView('pdf.generatePurchase', $data);
        Storage::put('pdf_purchases/'.$pdfName, $pdf->output());

        $purchase->receipt_pdf_filename = $pdfName;
        $purchase->save();

        Mail::to($purchase->customer_email)->send(new PurchaseConfirmationEmail($purchase));

        session()->forget('cart');

        $url = route('pdf.download',['pdfFilename' => 'Purchase'.$purchase->id.'.pdf']);

        $htmlMessage = "Purchase made successfully (Tickets were sent to email!) <a href='$url'><u>CLICK HERE TO DOWNLOAD THE TICKETS</u></a>";
        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
