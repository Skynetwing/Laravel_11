<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Razorpay\Api\Api;


class RazorpayController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        return view('razorpay.razorpay');
    }

    public function payment(Request $request)
    {
        $amountPaise = $request->input('amount') * 100;
        $receiptId = 'rcpt_' . uniqid();

        $order = $this->paymentService->createOrder($amountPaise, $receiptId, [
            'user_id' => auth()->id() ?? null
        ]);

        Payment::create([
            'razorpay_order_id' => $order->id,
            'razorpay_payment_id' => "",
            'razorpay_signature' => "",
            'amount' => $amountPaise,
            'currency' => $order->currency,
            'status' => $order->status,
            'user_id' => auth()->id() ?? null,
            'meta' => json_encode([
                'receipt' => $receiptId,
                'notes' => $order->notes
            ]),
        ]);

        return view('razorpay.payment', [
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'key' => config('services.razorpay.key'),
            'currency' => $order['currency'],
        ]);
    }

    public function callback(Request $request)
    {
        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        $attributes = [
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
        ];

        try {
            $this->paymentService->verifySignature($attributes);
            Payment::where([
                'razorpay_order_id' => $orderId,
                'user_id' => auth()->id() ?? null
            ])->update([
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'success',
            ]);
            // payment success logic
            return redirect()->route('razorpay.index')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            // payment fail logic
            return redirect()->route('razorpay.index')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function createOrder(int $amountPaise, string $receipt, array $notes = [])
    {
        $orderData = [
            'amount' => $amountPaise * 100,
            'currency' => 'INR', // Default to INR if not set
            'payment_capture' => 1, // 1 = auto-capture, 0 = manual capture
            'receipt' => $receipt,
            'notes' => $notes,
        ];

        return $orderData;
    }
}
