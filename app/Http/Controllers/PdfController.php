<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function downloadPdf(Request $request){

        $fileName = $request->pdfFilename;

        if (!empty($fileName)) {
            $filePath = storage_path('app/pdf_purchases/' . $fileName);

            if (file_exists($filePath)) {
                return response()->download($filePath, $fileName);
            }
        }

        return redirect()->route('cart.show')
            ->with('alert-type', 'danger')
            ->with('alert-msg', 'Pdf Not found.');
    }
}
