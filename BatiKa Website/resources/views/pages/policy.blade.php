<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Support Policy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-white">

    <x-navbar></x-navbar>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Judul Halaman (Ganti sesuai Shipping/Returns/Help) --}}
                <h1 class="fw-bold mb-4 display-5">Shipping Information</h1>
                
                <div class="text-muted lead mb-5">
                    Learn more about how we deliver our handcrafted Batik pieces to your doorstep.
                </div>

                {{-- Konten Kebijakan --}}
                <div class="policy-content">
                    <h4 class="fw-bold text-dark mt-4">1. Domestic Shipping</h4>
                    <p>We offer free shipping across Indonesia for orders above Rp 1.000.000. For orders below that amount, standard JNE/SiCepat rates apply.</p>

                    <h4 class="fw-bold text-dark mt-4">2. International Shipping</h4>
                    <p>We ship worldwide using DHL Express. International delivery times vary between 5-10 business days depending on your location.</p>

                    <h4 class="fw-bold text-dark mt-4">3. Processing Time</h4>
                    <p>Since our items are handcrafted, please allow 1-2 business days for us to inspect and pack your order with care.</p>

                    <div class="alert alert-light border border-primary mt-5 p-4 rounded-4 d-flex gap-3 align-items-start">
                        <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                        <div>
                            <h6 class="fw-bold text-primary">Need more help?</h6>
                            <p class="mb-0 small">If you have urgent questions regarding your package, please contact our support team at <a href="/contact">Contact Us</a> page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

</body>
</html>