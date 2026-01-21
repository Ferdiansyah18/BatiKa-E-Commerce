<?php
$order = App\Models\Order::latest()->first();
echo "Order ID: " . $order->id . PHP_EOL;
echo "Server Key: " . config('midtrans.server_key') . PHP_EOL;

\Midtrans\Config::$serverKey = config('midtrans.server_key');
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id' => $order->id . '-' . time(), // Unique ID to avoid "Order ID already used" error
        'gross_amount' => (int) $order->total_amount,
    ],
    'customer_details' => [
        'first_name' => $order->user->name,
        'email' => $order->user->email,
    ]
];

try {
    $token = \Midtrans\Snap::getSnapToken($params);
    echo "SUCCESS_TOKEN: " . $token . PHP_EOL;
} catch (\Exception $e) {
    echo "ERROR_MESSAGE: " . $e->getMessage() . PHP_EOL;
}
