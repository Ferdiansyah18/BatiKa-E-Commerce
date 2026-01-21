<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Order!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $order->user->name }},</p>
            <p>Your payment has been verified. Here are the details of your order:</p>
            
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

            <h3>Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total">Total Amount</td>
                        <td class="total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <h3>Shipping Address</h3>
            @php
                $address = is_string($order->shipping_address) ? json_decode($order->shipping_address, true) : $order->shipping_address;
            @endphp
            <p>
                {{ $address['name'] ?? '' }}<br>
                {{ $address['address'] ?? '' }}<br>
                {{ $address['city'] ?? '' }}, {{ $address['postal_code'] ?? '' }}<br>
                Phone: {{ $address['phone'] ?? '' }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BatiKa. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
