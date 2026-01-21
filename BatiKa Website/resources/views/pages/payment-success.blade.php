<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Order Confirmed</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-light-custom { background-color: #f8f9fa; }
        .ls-1 { letter-spacing: 1px; }

        /* Heartbeat/Ripple Animation behind the logo */
        @keyframes heartbeat-ripple {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .success-icon-wrapper {
            position: relative; /* Create context for pseudo-elem */
            z-index: 1; /* Keep icon on top */
            /* Ensure original styles are preserved if not in app.css, 
               but app.css handles the base look. We just add the animation anchor. */
        }

        .success-icon-wrapper::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: inherit; /* Use same color as parent (gold) */
            /* Or explicit: background-color: #C89D66; */
            background-color: #C89D66; 
            border-radius: 50%;
            z-index: -1; /* Behind the logo */
            animation: heartbeat-ripple 2s infinite cubic-bezier(0, 0, 0.2, 1);
        }
    </style>
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative animate-up">
                        
                        <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background: linear-gradient(90deg, var(--color-primary), #8D6E63);"></div>

                        <div class="card-body p-5 text-center">
                            
                            <!-- Removed manual style override classes, relying on app.css + this internal style -->
                            <div class="success-icon-wrapper mb-5 mx-auto d-flex align-items-center justify-content-center rounded-circle shadow">
                                <i class="bi bi-check-lg text-white display-3"></i>
                            </div>

                            <h2 class="fw-bold text-dark mb-2">Payment Successful!</h2>
                            <p class="text-muted mb-4">
                                Thank you for your purchase. Your order has been confirmed and will be shipped soon.
                            </p>

                            <div class="bg-light-custom rounded-4 p-4 mb-4 text-start">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Order Number</small>
                                        <span class="fw-bold text-dark text-nowrap">#{{ $order->order_number }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Date</small>
                                        <span class="fw-bold text-dark">{{ $order->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Payment Method</small>
                                        <span class="fw-bold text-dark text-uppercase">
                                            @php
                                                $paymentType = $paymentType ?? 'midtrans'; // Ensure it's set
                                                $paymentMap = [
                                                    'credit_card' => 'Credit Card',
                                                    'gopay' => 'GoPay',
                                                    'shopeepay' => 'ShopeePay',
                                                    'qris' => 'QRIS',
                                                    'bank_transfer' => 'Bank Transfer',
                                                    'bank_transfer_bca' => 'BCA Virtual Account',
                                                    'bank_transfer_bni' => 'BNI Virtual Account',
                                                    'bank_transfer_bri' => 'BRI Virtual Account',
                                                    'bank_transfer_permata' => 'Permata Virtual Account',
                                                    'bank_transfer_mandiri' => 'Mandiri Bill Payment',
                                                    'echannel' => 'Mandiri Bill',
                                                    'bca_klikbca' => 'KlikBCA',
                                                    'bca_klikpay' => 'BCA KlikPay',
                                                    'cstore' => 'Convenience Store',
                                                    'cstore_indomaret' => 'Indomaret',
                                                    'cstore_alfamart' => 'Alfamart',
                                                    'midtrans' => 'Online Payment',
                                                ];
                                                $displayPayment = $paymentMap[$paymentType] ?? ucwords(str_replace('_', ' ', $paymentType));
                                            @endphp
                                            {{ $displayPayment }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Total Amount</small>
                                        <span class="fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="small text-muted mb-4">
                                A confirmation email has been sent to <strong>{{ $order->user->email }}</strong>
                            </p>

                            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                                <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-pill py-3 px-4 fw-medium">
                                    <i class="bi bi-arrow-left me-2"></i> Shop Again
                                </a>
                                
                                <a href="{{ route('account.dashboard') }}#orders" class="btn btn-primary rounded-pill py-3 px-4 fw-bold shadow-sm btn-buy">
                                    View My Order <i class="bi bi-box-seam ms-2"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        Need help? <a href="#" class="text-primary text-decoration-none fw-bold">Contact Support</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    </body>
</html>