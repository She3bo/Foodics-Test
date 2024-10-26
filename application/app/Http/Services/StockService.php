<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Exceptions\OutOfStockException;

class StockService {
    /**
     * @throws OutOfStockException
     */
    public function checkStock(Product $product, int $quantity):void
    {
        foreach ($product->ingredients as $ingredient) {
            $requiredQuantity = ($ingredient->pivot->amount * $quantity) / 1000;
            if ($ingredient->stock < $requiredQuantity) {
                throw new OutOfStockException("Insufficient stock for {$ingredient->name}", 422);
            }
        }
    }

    public function updateStock(Product $product, int $quantity): void
    {
        foreach ($product->ingredients as $ingredient) {
            $ingredient->decrement('stock', ($ingredient->pivot->amount * $quantity) / 1000);
        }
    }
}
