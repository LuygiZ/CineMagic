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

        $purchase = Purchase::find($request->purchase);

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

        session()->forget('cart');

        $url = route('pdf.download',['pdfFilename' => 'Purchase'.$purchase->id.'.pdf']);

        $htmlMessage = "Purchase made successfully! <a href='$url'><u>CLICK HERE TO DOWNLOAD THE TICKETS</u></a>";
        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function downloadPdf(Request $request){

        $fileName = $request->pdfFilename;

        if (!empty($fileName)) {
            $filePath = storage_path('app/pdf_purchases/' . $fileName);

            if (file_exists($filePath)) {
                return response()->download($filePath, $fileName);
            }
        }

        return redirect()->route('cart.show')
            ->with('alert-type', 'error')
            ->with('alert-msg', 'Pdf Not found.');
    }
}
