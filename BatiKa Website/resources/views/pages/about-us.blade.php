<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Our Story</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="text-primary fw-bold text-uppercase ls-wider small">The Brand</span>
                <h1 class="display-4 fw-bold text-dark mb-3">Crafting Tradition</h1>
                <p class="text-muted lead">Discover the story behind every stitch and pattern.</p>
            </div>
        </div>
    </section>

    <section class="container pb-5 mb-5">
        <div class="row align-items-center g-5">
            
            <div class="col-12 col-lg-6">
                <div class="image-collage position-relative pe-lg-4">
                    <div class="rounded-4 overflow-hidden shadow-lg position-relative z-1">
                        <img src="{{ asset('images/about-1.jpg') }}" alt="BatiKa Workshop" class="w-100 object-fit-cover" style="height: 500px;">
                    </div>
                    
                    <div class="floating-img position-absolute bottom-0 end-0 translate-middle-y z-2 d-none d-md-block" style="margin-right: -20px; margin-bottom: -40px;">
                        <div class="rounded-4 overflow-hidden shadow-lg border border-4 border-white">
                            <img src="{{ asset('images/about-2.jpg') }}" alt="Detail" width="220" height="220" class="object-fit-cover">
                        </div>
                    </div>

                    <div class="position-absolute top-0 start-0 translate-middle z-0 opacity-25">
                         <i class="bi bi-flower1 display-1 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5 offset-lg-1">
                <div class="ps-lg-4">
                    <h6 class="text-primary fw-bold text-uppercase ls-wider mb-3">About Us</h6>

                    <h2 class="display-6 fw-bold mb-4 position-relative pb-3 title-underline">
                        We design modern batik bags with an elegant touch.
                    </h2>

                    <p class="lead text-muted mb-4">
                        At BatiKa, we believe that every pattern tells a story. Our journey began with a simple mission.
                    </p>
                    <p class="text-muted mb-5">
                        To bring the timeless beauty of Indonesian & Malaysian batik into everyday life through modern, handcrafted bags that honor tradition while embracing contemporary style.
                    </p>

                    <div class="d-flex align-items-center gap-3 border-top pt-4" style="border-color: var(--color-border) !important;">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                           <i class="bi bi-gem fs-4"></i> 
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 h6">BatiKa Team</h5>
                            <small class="text-muted">Founders of BatiKa</small>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </section>

    <section class="bg-white py-5 mb-5">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4 h-100">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-brush fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Handcrafted Quality</h5>
                        <p class="text-muted small">Every stitch is made by experienced artisans who have dedicated their lives to the art of bag making.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 h-100 border-start border-end border-light-subtle">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-flower3 fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Authentic Batik</h5>
                        <p class="text-muted small">We source our fabrics directly from local batik villages to ensure authenticity and support the community.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 h-100">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-recycle fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Sustainable Fashion</h5>
                        <p class="text-muted small">We minimize waste by using leftover premium fabrics for our smaller accessories and packaging.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="container pb-5 mb-3">
    <div class="card border-0 rounded-5 overflow-hidden shadow position-relative text-white" style="background-color: #3B2F2F;">
        
        {{-- SOLUSI: Gunakan tag <img> biasa, bukan CSS background --}}
        {{-- Class 'object-fit-cover' memastikan gambar tidak gepeng (stretch) --}}
        <img src="{{ asset('images/bg-about-us.jpg') }}" 
             class="position-absolute top-0 start-0 w-100 h-100 opacity-25 object-fit-cover" 
             alt="Background Pattern">
        
        <div class="card-body p-5 text-center position-relative z-1">
            <h2 class="fw-bold mb-3">Ready to carry a piece of art?</h2>
            <p class="mb-4 text-white-50">Explore our latest collection and find the perfect match for your style.</p>
            <a href="/shop" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm btn-buy">
                Shop Collection
            </a>
        </div>
    </div>
</section>

    <x-footer></x-footer>

</body>
</html>