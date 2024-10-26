<?php

namespace App\Http\Services;

use App\Jobs\LowStockNotification;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;

class NotificationService {
    public function notifyLowStock(): void
    {
        $lowStockIngredients = Ingredient::where('stock', '<', DB::raw('initial_stock * 0.5'))
            ->where('notified', false)
            ->get();
        foreach ($lowStockIngredients as $ingredient) {
            LowStockNotification::dispatch($ingredient);
            $ingredient->update(['notified' => true]);
        }
    }
}
