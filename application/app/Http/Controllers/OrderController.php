<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    protected OrderService $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function placeOrder(CreateOrderRequest $request): JsonResponse
    {
        try {
            $this->orderService->processOrder($request->all());
            return response()->json(['message' => 'Order placed successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
