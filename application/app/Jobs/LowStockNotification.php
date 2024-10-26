<?php

namespace App\Jobs;

use App\Mail\StockAlertEmail;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class LowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Ingredient $ingredient;

    /**
     * Create a new job instance.
     */
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to(config('mail.stoke_mail'))->send(new StockAlertEmail($this->ingredient));
    }
}
