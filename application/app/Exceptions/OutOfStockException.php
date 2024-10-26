<?php

namespace App\Exceptions;
use Exception;
use Illuminate\Http\JsonResponse;

class OutOfStockException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], 422);
    }
}
