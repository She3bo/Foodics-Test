<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Jobs\SendMail;
use App\Mail\StockAlertEmail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function placeOrder(CreateOrderRequest $request): JsonResponse
    {
        $validated = $this->validateAvailableStock($request);
        if (!$validated[0]['status']) {
            return response()->json($validated, 422);
        }
        $orders = $request->get('products');
        foreach ($orders as $order) {
            $sendEmail = false;
            $productId = $order['product_id'];
            $quantity = $order['quantity'];
            $product = Product::where('id', $productId)->with('ingredients')->first();
            $ingredients = $product->ingredients;
            foreach ($ingredients as $ingredient) {
                $consumedAmount = ($ingredient->pivot->amount * $quantity) / 1000;
                $ingredient->stock -= $consumedAmount;
                if ($ingredient->stock / $ingredient->initial_stock <= 0.5) {
                    $sendEmail = true;
                }
                $ingredient->save();
            }
            if ($sendEmail) {
                SendMail::dispatch($product);
            }
            Order::query()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
        return response()->json(['message' => 'Order placed successfully']);
    }

    private function validateAvailableStock(CreateOrderRequest $request): array
    {
        $errors = [];
        $orders = $request->get('products');
        foreach ($orders as $order) {
            $productId = $order['product_id'];
            $quantity = $order['quantity'];
            $product = Product::where('id', $productId)->with('ingredients')->first();
            $ingredients = $product->ingredients;
            foreach ($ingredients as $ingredient) {
                $consumedAmount = ($ingredient->pivot->amount * $quantity) / 1000;
                if ($ingredient->stock < $consumedAmount) {
                    $errors [] = [
                        'status' => false,
                        'message' => $product->name . ' not enough in stock',
                    ];
                }
            }
        }
        if (empty($errors)) {
            $errors [] = [
                'status' => true,
            ];
        }
        return $errors;
    }
}
