<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Contact Us</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <x-navbar></x-navbar>

    <div class="container py-5 mt-5">
        <div class="row g-5 justify-content-center">
            
            {{-- Info Kontak --}}
            <div class="col-lg-5">
                <span class="text-primary fw-bold text-uppercase ls-wider small">Get in Touch</span>
                <h1 class="display-4 fw-bold mb-4">We'd love to hear from you.</h1>
                <p class="text-muted lead mb-5">Have a question about a product, shipping, or just want to say hi? Drop us a message.</p>

                <div class="d-flex gap-4 mb-4">
                    <div class="bg-white p-3 rounded-circle shadow-sm text-primary">
                        <i class="bi bi-geo-alt fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Our Studio</h5>
                        <p class="text-muted mb-0">Jl. Batik Nusantara No. 88,<br>Yogyakarta, Indonesia</p>
                    </div>
                </div>

                <div class="d-flex gap-4 mb-4">
                    <div class="bg-white p-3 rounded-circle shadow-sm text-primary">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Email Us</h5>
                        <p class="text-muted mb-0">hello@batika.com</p>
                    </div>
                </div>

                <div class="d-flex gap-4">
                    <div class="bg-white p-3 rounded-circle shadow-sm text-primary">
                        <i class="bi bi-whatsapp fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">WhatsApp</h5>
                        <p class="text-muted mb-0">+62 812 3456 7890</p>
                    </div>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-5 p-5">
                    <h3 class="fw-bold mb-4">Send a Message</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">First Name</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" placeholder="John">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Last Name</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" placeholder="Doe">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Email Address</label>
                                <input type="email" class="form-control form-control-lg bg-light border-0" placeholder="john@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">Message</label>
                                <textarea class="form-control form-control-lg bg-light border-0" rows="5" placeholder="How can we help you?"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

</body>
</html>