<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Product $product;
    /**
     * Create a new message instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function build()
    {
        return $this->subject("Stock Alert")
            ->view('emails.stockAlert')->with(['product' => $this->product]);
    }
}
