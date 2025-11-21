<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    protected $message = 'Insufficient stock available';

    protected $code = 422;

    public function render($request)
    {
        return response()->json([
            'error' => 'Insufficient stock',
            'message' => $this->message,
        ], $this->code);
    }
}

class OrderProcessingException extends Exception
{
    protected $message = 'Order could not be processed';

    protected $code = 500;

    public function render($request)
    {
        return response()->json([
            'error' => 'Order processing failed',
            'message' => $this->message,
        ], $this->code);
    }
}
