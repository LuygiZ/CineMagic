<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf(){

        $data = [
            'title' => "Cinemagic",
            'date'  => date('m/d/Y'),
            'ticketCode' => "1234567"
        ];

        $pdf = Pdf::loadView('pdf.generatePurchase', $data);
        return $pdf->download('Purchase.pdf');
    }
}
