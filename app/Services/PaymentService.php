<?php

namespace App\Services;

use Razorpay\Api\Api;

class PaymentService
{
    protected $api;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function createOrder(int $amountPaise, string $receipt, array $notes = [])
    {
        $order = $this->api->order->create([
            'amount' => $amountPaise,
            'currency' => 'INR',
            'receipt' => $receipt,
            'payment_capture' => 1,
            'notes' => $notes,
        ]);
        return $order;
    }

    public function verifySignature(array $attributes)
    {
        return $this->api->utility->verifyPaymentSignature($attributes);
    }
}
