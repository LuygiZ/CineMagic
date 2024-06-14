<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $purchase = new Purchase();
        $purchase->id = 1;
        $purchase->customer_name = "joao";
        $purchase->date = date('d/m/Y');
        $purchase->customer_email = "123@mail.com";
        $purchase->customer_nif = 123456789;
        $purchase->total_price = 100;

        $data = [
            'title' => "CineMagic",
            'date' => date('m/d/Y'),
            'tickets' => session('cart'),
            'purchase' => $purchase
        ];

        $pdf = Pdf::loadView('pdf.generatePurchase', $data);
        Storage::put('pdf_purchases/Purchase'.$purchase->id.'.pdf', $pdf->output());

        return $pdf->download('Purchase.pdf');
    }
}
