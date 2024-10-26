<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService {
    protected $stockService;
    protected $notificationService;

    public function __construct(StockService $stockService, NotificationService $notificationService) {
        $this->stockService = $stockService;
        $this->notificationService = $notificationService;
    }

    public function processOrder($orderDetails): void
    {
        foreach ($orderDetails['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $this->stockService->checkStock($product, $productData['quantity']);
            $this->stockService->updateStock($product, $productData['quantity']);
            $this->createOrder($product, $productData['quantity']);
        }
        $this->notificationService->notifyLowStock();
    }
    private function createOrder(Product $product, int $quantity): void
    {
        Order::query()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }
}
