<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceipt;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // If already paid, redirect to success
        if ($order->status == 'processing' || $order->status == 'on_delivery' || $order->status == 'delivered') {
             return redirect()->route('payment.success', ['order' => $order]);
        }

        // Regenerate Snap Token if missing
        if (empty($order->snap_token)) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) $order->total_amount,
                ],
                // Minimal customer details for regeneration to avoid errors
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);
                $order->refresh(); // Ensure the model has the new token
            } catch (\Exception $e) {
                // If regeneration fails, maybe keys are still wrong or order is invalid
                return redirect()->back()->with('error', 'Unable to proceed with payment: ' . $e->getMessage());
            }
        }

        return view('pages.payment-pay', compact('order'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            $order = Order::find($request->order_id);
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($order->payment_status !== 'paid') {
                    // Update Payment Method from Request if available
                    $readableType = $this->getReadablePaymentType($request);

                    $order->update([
                        'status' => 'processing',
                        'payment_status' => 'paid',
                        'payment_method' => $readableType // Save specific method
                    ]);
                    Mail::to($order->user->email)->send(new OrderReceipt($order));
                }
            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
            }
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['message' => 'Invalid signature'], 400);
    }
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Manual Status Check (For Localhost/Non-Webhook environments)
        // We ask Midtrans: "Hey, what happened to this order?"
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $status = (object) \Midtrans\Transaction::status($order->id);
            $transactionStatus = $status->transaction_status ?? 'pending';
            $fraudStatus = $status->fraud_status ?? 'accept';

            // Logic similar to webhook
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    // TODO: Set payment status to challenge
                } else if ($fraudStatus == 'accept') {
                    if ($order->payment_status !== 'paid') {
                        $readableType = $this->getReadablePaymentType($status);
                        
                        $order->update([
                            'status' => 'processing',
                            'payment_status' => 'paid',
                            'payment_method' => $readableType
                        ]);
                        Mail::to($order->user->email)->send(new OrderReceipt($order));
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                if ($order->payment_status !== 'paid') {
                    $readableType = $this->getReadablePaymentType($status);

                    $order->update([
                        'status' => 'processing',
                        'payment_status' => 'paid',
                        'payment_method' => $readableType
                    ]);
                    Mail::to($order->user->email)->send(new OrderReceipt($order));
                }
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
            } else if ($transactionStatus == 'pending') {
                $order->update([
                    'status' => 'pending',
                    'payment_status' => 'pending'
                ]);
            }

            $paymentType = $status->payment_type ?? 'midtrans';
            
            // Refine bank transfer type
            if ($paymentType == 'bank_transfer') {
                // Determine specific bank
                if (isset($status->va_numbers) && is_array($status->va_numbers) && count($status->va_numbers) > 0) {
                    $bank = $status->va_numbers[0]->bank ?? '';
                    if ($bank) {
                        $paymentType = 'bank_transfer_' . $bank;
                    }
                } elseif (isset($status->permata_va_number)) {
                    $paymentType = 'bank_transfer_permata';
                }
            } elseif ($paymentType == 'echannel') {
                 $paymentType = 'bank_transfer_mandiri';
            }

        } catch (\Exception $e) {
            $paymentType = 'midtrans';
        }

        return view('pages.payment-success', compact('order', 'paymentType'));
    }
    private function getReadablePaymentType($status)
    {
        $type = $status->payment_type ?? 'midtrans';
        
        if ($type == 'bank_transfer') {
            if (isset($status->va_numbers) && is_array($status->va_numbers) && count($status->va_numbers) > 0) {
                $bank = $status->va_numbers[0]->bank ?? '';
                if ($bank) {
                    return 'Bank Transfer (' . strtoupper($bank) . ')';
                }
            } elseif (isset($status->permata_va_number)) {
                return 'Bank Transfer (Permata)';
            }
            return 'Bank Transfer';
        } 
        
        if ($type == 'echannel') {
             return 'Bank Transfer (Mandiri)';
        }

        if ($type == 'gopay') {
            return 'GoPay';
        }
        
        if ($type == 'cstore') {
            return ucfirst($status->store ?? 'Convienience Store');
        }

        return ucwords(str_replace('_', ' ', $type));
    }
}
