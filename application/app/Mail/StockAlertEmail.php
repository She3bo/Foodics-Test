<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockAlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Ingredient $ingredient;
    /**
     * Create a new message instance.
     */
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }
    public function build()
    {
        return $this->subject("Stock Alert")
            ->view('emails.stockAlert')->with(['ingredient' => $this->ingredient]);
    }
}
