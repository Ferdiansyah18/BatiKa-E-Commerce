<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - BatiKa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact;
        }
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        .invoice-header {
            background-color: #fff;
            padding: 40px;
            border-bottom: 2px solid #f0f0f0;
        }
        .invoice-body {
            padding: 40px;
        }
        .invoice-footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            border-top: 1px solid #eee;
        }
        .logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #C89D66;
            font-size: 24px;
        }
        .table-invoice th {
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }
        .table-invoice td {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .table-invoice tr:last-child td {
            border-bottom: none;
        }
        @media print {
            body {
                background-color: white;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4 invoice-container-header no-print" style="max-width: 800px; margin: 0 auto;">
            <a href="{{ route('account.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-printer-fill me-2"></i> Print Invoice
            </button>
        </div>

        <div class="invoice-container">
            <div class="invoice-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <!-- Replace with actual logo if available -->
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <!-- Helper for logo, assuming SVG from other parts of app/logo path -->
                           <span class="logo-text">BatiKa.</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">INVOICE</h5>
                        <p class="text-muted mb-0">#{{ $order->order_number }}</p>
                    </div>
                    <div class="text-end">
                        <h6 class="fw-bold text-uppercase text-muted mb-2">Status</h6>
                        @if($order->payment_status == 'paid')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-25">Paid</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill border border-warning border-opacity-25">{{ ucfirst($order->payment_status) }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-6">
                        <small class="text-uppercase text-muted fw-bold ls-1 d-block mb-2">Billed To</small>
                        @php
                            $address = $order->shipping_address;
                        @endphp
                        <h6 class="fw-bold mb-1">{{ $address['name'] ?? $order->user->name }}</h6>
                        <p class="text-muted mb-0 lh-sm">
                            {{ $address['address'] ?? '' }}<br>
                            {{ $address['city'] ?? '' }}, {{ $address['postal_code'] ?? '' }}<br>
                            {{ $address['phone'] ?? $order->user->phone }}<br>
                            {{ $address['email'] ?? $order->user->email }}
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <div class="mb-3">
                            <small class="text-uppercase text-muted fw-bold ls-1 d-block mb-1">Order Date</small>
                            <span class="fw-bold text-dark">{{ $order->created_at->format('d F Y') }}</span>
                        </div>
                        <div>
                             <small class="text-uppercase text-muted fw-bold ls-1 d-block mb-1">Payment Method</small>
                             <span class="fw-bold text-dark">{{ $order->payment_method }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-body">
                <table class="table table-borderless table-invoice mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Item Description</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <h6 class="fw-bold mb-0 text-dark">{{ $item->product->name }}</h6>
                                <!-- Optionally add variant info here if available later -->
                            </td>
                            <td class="text-center text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center fw-bold">{{ $item->quantity }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="row justify-content-end mt-4">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3">
                            <span class="fs-5 fw-bold text-dark">Total</span>
                            <span class="fs-5 fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-footer text-center">
                <p class="fw-bold text-dark mb-1">Thank you for shopping with BatiKa!</p>
                <p class="text-muted small mb-0">If you have any questions about this invoice, please contact support@batika.com</p>
                <div class="mt-4 pt-4 border-top">
                     <small class="text-muted">BatiKa E-Commerce &copy; {{ date('Y') }}</small>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
