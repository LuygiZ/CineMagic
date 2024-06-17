<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;


    protected $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Purchase Confirmation',
        );
    }


    public function build()
    {
        return $this->view('email.purchaseConfirmationEmail')
                    ->with([
                        'purchase' => $this->purchase,
                    ])
                    ->attach(storage_path('app/pdf_purchases/' . $this->purchase->receipt_pdf_filename));
    }
}
