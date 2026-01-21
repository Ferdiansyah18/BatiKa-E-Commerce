<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa E-Commerce | Official Website</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <x-navbar></x-navbar>
    <section class="hero-section position-relative overflow-hidden d-flex align-items-center min-vh-100 py-5 py-lg-0" 
             style="background-color: var(--color-bg);">
        
        <div class="position-absolute top-0 end-0 rounded-circle opacity-10" 
             style="width: 600px; height: 600px; background: var(--color-primary); transform: translate(30%, -30%); z-index: 0;">
        </div>

        <div class="container position-relative z-1">
            <div class="row align-items-center">
                
                <div class="col-12 col-lg-6 order-2 order-lg-1 text-center text-lg-start mt-5 mt-lg-0">
                    <span class="d-inline-block py-1 px-3 rounded-pill bg-white text-primary fw-bold small shadow-sm mb-3 animate-on-scroll">
                        🌿 100% Handmade & Sustainable
                    </span>
                    
                    <h1 class="display-3 fw-bold lh-sm mb-3 animate-on-scroll delay-100" style="color: var(--color-text);">
                        A Touch of <span style="color: var(--color-primary); font-family: serif; font-style: italic;">Batik,</span> <br>
                        A World of Style.
                    </h1>
                    
                    <p class="lead text-secondary mb-4 col-lg-10 mx-auto mx-lg-0 animate-on-scroll delay-200">
                        Sustainably handmade by local artisans. Each bag celebrates Indonesian culture, premium craftsmanship, and conscious living.
                    </p>
                    
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start animate-on-scroll delay-300">
                        <a href="#" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">Shop Now</a>
                        <a href="#" class="btn btn-outline-dark btn-lg rounded-pill px-4 icon-link icon-link-hover">
                            View Lookbook <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="mt-5 d-flex align-items-center justify-content-center justify-content-lg-start gap-3 animate-on-scroll delay-400">
                        <div class="d-flex">
                            <img src="https://i.pravatar.cc/100?img=1" class="rounded-circle border border-2 border-white" width="40" alt="">
                            <img src="https://i.pravatar.cc/100?img=5" class="rounded-circle border border-2 border-white ms-n3" width="40" alt="" style="margin-left: -15px;">
                            <img src="https://i.pravatar.cc/100?img=9" class="rounded-circle border border-2 border-white ms-n3" width="40" alt="" style="margin-left: -15px;">
                        </div>
                        <div>
                            <p class="mb-0 fw-bold small">4.9/5 Rating</p>
                            <p class="mb-0 small text-muted">from 1k+ Happy Customers</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 order-1 order-lg-2 text-center position-relative">
                    <div class="hero-image-wrapper position-relative d-inline-block animate-on-scroll delay-200">
                        <img class="img-fluid floating-anim shadow-lg" 
                             src="{{ asset('images/hero-img.png')}}" 
                             alt="Batik Bag Collection"
                             style="border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; max-height: 550px; object-fit: cover;">
                        
                        <div class="card position-absolute border-0 shadow-lg p-3 rounded-4 floating-anim-delayed" 
                             style="bottom: 10%; left: -20px; width: 180px; text-align: left; animation-delay: 1s;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary">
                                    <i class="bi bi-shield-check-fill"></i>
                                </div>
                                <span class="fw-bold small">Premium Quality</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Genuine Leather & Authentic Batik.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-us-section py-5 position-relative overflow-hidden bg-white">
        <div class="container py-lg-5">
            <div class="row gy-5 align-items-center justify-content-between">

                <div class="col-12 col-lg-6 position-relative">
                    <div class="position-absolute opacity-10 rounded-4 d-none d-lg-block"
                         style="background-color: var(--color-bg-card); width: 90%; height: 100%; top: -20px; left: -20px; z-index: 0;">
                    </div>
                    <div class="position-relative z-1 pe-lg-4">
                        <img class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover"
                             src="{{ asset('images/about-us-img.jpg') }}"
                             alt="Our Batik Workshop"
                             style="min-height: 400px;">
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="ps-lg-4">
                        <h6 class="text-primary fw-bold text-uppercase ls-wider mb-3 animate-on-scroll">About Us</h6>

                        <h2 class="display-6 fw-bold mb-4 animate-on-scroll delay-100">
                            We design modern batik bags with an elegant touch.
                        </h2>

                        <p class="lead text-muted mb-4 animate-on-scroll delay-200">
                            At BatiKa, we believe that every pattern tells a story. Our journey began with a simple mission.
                        </p>
                        <p class="text-muted mb-5 animate-on-scroll delay-300">
                            To bring the timeless beauty of Indonesian & Malaysian batik into everyday life through modern, handcrafted bags that honor tradition while embracing contemporary style.
                        </p>

                        <div class="d-flex align-items-center gap-3 border-top pt-4 animate-on-scroll delay-400" style="border-color: var(--color-border) !important;">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                               <i class="bi bi-gem"></i> 
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 h6">BatiKa Team</h5>
                                <small class="text-muted">Founders of BatiKa</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="featured-products-section py-5 position-relative">
        <div class="container py-4">
            
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2 animate-on-scroll">Best Sellers</h6>
                <h2 class="display-6 fw-bold text-dark animate-on-scroll delay-100">Featured Products</h2>
                <p class="text-muted mt-2 animate-on-scroll delay-200">Discover our handpicked premium batik collections</p>
            </div>

            <div class="row g-4 justify-content-center">
                @forelse($featuredProducts as $product)
                <div class="col-12 col-sm-6 col-lg-4 animate-on-scroll delay-300">
                    <div class="product-card card border-0 rounded-4 overflow-hidden h-100">
                        
                        <div class="product-image-wrapper position-relative overflow-hidden bg-light">
                            <!-- New Arrival Badge Logic (Optional) -->
                            @if($loop->first)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 z-2">New Arrival</span>
                            @endif
                            
                            <img src="{{ Storage::url($product->thumbnail) }}" class="card-img-top w-100" alt="{{ $product->name }}">
                            
                            <a href="{{ route('product.detail', $product->slug) }}" class="stretched-link"></a>
                        </div>

                        <div class="card-body text-center p-4">
                            <div class="text-warning small mb-2">
                                @php
                                    $rating = $product->reviews_avg_rating ?? 0;
                                @endphp
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= round($rating) ? '-fill' : '' }}"></i>
                                @endfor
                                <span class="text-muted ms-1" style="font-size: 0.8rem;">({{ $product->reviews_count ?? 0 }})</span>
                            </div>

                            <h5 class="card-title fw-bold mb-1">
                                <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none text-dark d-none d-lg-block stretched-link">{{ $product->name }}</a>
                                <span class="d-lg-none text-dark">{{ $product->name }}</span>
                            </h5>
                            <p class="text-muted small mb-2">{{ $product->category->name ?? 'Premium Collection' }}</p>
                            
                            @if($product->discount_price)
                                <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</h4>
                                <small class="text-decoration-line-through text-muted" style="font-size: 0.9rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                            @else
                                <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No featured products yet.</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary px-5 py-2 rounded-pill fw-semibold">View All Products</a>
            </div>

        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2 animate-on-scroll">Discover</h6>
                <h2 class="display-5 fw-bold text-dark animate-on-scroll delay-100">Our Collections</h2>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 animate-on-scroll delay-200">
                    <div class="collection-card card-classic h-100 rounded-4 overflow-hidden shadow-lg group">
                        <div class="card-content d-flex flex-column align-items-center justify-content-center text-center p-5 h-100">
                            <i class="bi bi-flower1 fs-1 text-white opacity-75 mb-3"></i>
                            <h3 class="text-white fw-bold mb-3">Classic Batik <br> Series</h3>
                            <a class="btn btn-light rounded-pill px-5 py-2 fw-bold stretched-link" href="#">
                                View
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 animate-on-scroll delay-300">
                    <div class="collection-card card-luxury h-100 rounded-4 overflow-hidden shadow-lg">
                        <div class="card-content d-flex flex-column align-items-center justify-content-center text-center p-5 h-100">
                            <i class="bi bi-stars fs-1 text-white opacity-75 mb-3"></i>
                            <h3 class="text-white fw-bold mb-3">Luxury Goldline <br> Series</h3>
                            <a class="btn btn-light rounded-pill px-5 py-2 fw-bold stretched-link" href="#">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="choose-us-section py-5 position-relative" style="background-color: var(--color-bg-light);">
        <div class="container py-4">
            
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2 animate-on-scroll">The BatiKa Standard</h6>
                <h2 class="display-6 fw-bold animate-on-scroll delay-100">Why Choose Us?</h2>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col animate-on-scroll delay-100">
                    <div class="feature-card h-100 p-4 rounded-4 bg-white text-center transition-card border-0 shadow-sm">
                        <div class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle mb-4 text-primary bg-primary bg-opacity-10">
                            <i class="bi bi-brush fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Handcrafted Batik</h5>
                        <p class="text-muted small mb-0">
                            Every stroke is manually drawn by skilled artisans, ensuring no two bags are exactly alike.
                        </p>
                    </div>
                </div>
                <div class="col animate-on-scroll delay-200">
                    <div class="feature-card h-100 p-4 rounded-4 bg-white text-center transition-card border-0 shadow-sm">
                        <div class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle mb-4 text-primary bg-primary bg-opacity-10">
                            <i class="bi bi-gem fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Premium Material</h5>
                        <p class="text-muted small mb-0">
                            We use only high-grade genuine leather and the finest cotton for durability and luxury.
                        </p>
                    </div>
                </div>
                <div class="col animate-on-scroll delay-300">
                    <div class="feature-card h-100 p-4 rounded-4 bg-white text-center transition-card border-0 shadow-sm">
                        <div class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle mb-4 text-primary bg-primary bg-opacity-10">
                            <i class="bi bi-flower1 fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Sustainable</h5>
                        <p class="text-muted small mb-0">
                            Eco-friendly dyes and zero-waste production processes to protect our heritage.
                        </p>
                    </div>
                </div>
                <div class="col animate-on-scroll delay-400">
                    <div class="feature-card h-100 p-4 rounded-4 bg-white text-center transition-card border-0 shadow-sm">
                        <div class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle mb-4 text-primary bg-primary bg-opacity-10">
                            <i class="bi bi-stars fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Limited Edition</h5>
                        <p class="text-muted small mb-0">
                            Exclusive designs released in small batches. Own a piece of art that stands out.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="customer-reviews-section py-5 position-relative" style="background-color: var(--color-bg);">
        <div class="container py-4">
            
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2 animate-on-scroll">Testimonials</h6>
                <h2 class="display-6 fw-bold animate-on-scroll delay-100">Loved by Locals & Tourists</h2>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                <div class="col animate-on-scroll delay-100">
                    <div class="review-card h-100 bg-white p-4 rounded-4 shadow-sm border-0 position-relative d-flex flex-column justify-content-between">
                        <i class="bi bi-quote position-absolute text-primary opacity-10" style="font-size: 5rem; top: -10px; left: 10px;"></i>
                        <div class="position-relative z-1 mb-4 pt-3">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-muted fst-italic mb-0">"The craftsmanship is exceptional — truly a timeless piece."</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 border-top pt-3 mt-auto">
                            <img src="https://i.pravatar.cc/150?img=32" alt="Sarah J." height="50" width="50" class="rounded-circle object-fit-cover shadow-sm">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center gap-1">
                                    <h6 class="fw-bold mb-0">Sarah Jenkins</h6>
                                    <i class="bi bi-patch-check-fill text-primary small" title="Verified Buyer"></i>
                                </div>
                                <small class="text-muted" style="font-size: 0.8rem;">Jakarta, Indonesia</small>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col animate-on-scroll delay-200">
                <div class="review-card h-100 bg-white p-4 rounded-4 shadow-sm border-0 position-relative d-flex flex-column justify-content-between">
                    <i class="bi bi-quote position-absolute text-primary opacity-10" style="font-size: 5rem; top: -10px; left: 10px;"></i>
                    
                    <div class="position-relative z-1 mb-4 pt-3">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted fst-italic mb-0">
                            "A perfect fusion of heritage and modern elegance. I bought this as a gift for my mother and she absolutely adores it."
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3 border-top pt-3 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=11" alt="User" height="50" width="50" class="rounded-circle object-fit-cover shadow-sm">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-1">
                                <h6 class="fw-bold mb-0">Michael Tan</h6>
                                <i class="bi bi-patch-check-fill text-primary small" title="Verified Buyer"></i>
                            </div>
                            <small class="text-muted" style="font-size: 0.8rem;">Singapore</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col animate-on-scroll delay-300">
                <div class="review-card h-100 bg-white p-4 rounded-4 shadow-sm border-0 position-relative d-flex flex-column justify-content-between">
                    <i class="bi bi-quote position-absolute text-primary opacity-10" style="font-size: 5rem; top: -10px; left: 10px;"></i>
                    
                    <div class="position-relative z-1 mb-4 pt-3">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="text-muted fst-italic mb-0">
                            "The batik detailing is stunning. I get compliments everywhere I go. Definitely worth the price for such quality."
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3 border-top pt-3 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=5" alt="User" height="50" width="50" class="rounded-circle object-fit-cover shadow-sm">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-1">
                                <h6 class="fw-bold mb-0">Amelia R.</h6>
                                <i class="bi bi-patch-check-fill text-primary small" title="Verified Buyer"></i>
                            </div>
                            <small class="text-muted" style="font-size: 0.8rem;">Bali, Indonesia</small>
                        </div>
                    </div>
                </div>
            </div>

              </div>
        </div>
    </section>

    <footer class="footer pt-5 pb-3" style="background-color: var(--color-text); color: var(--color-bg);">
        <div class="container">
            <div class="row g-4 justify-content-between">
                
                <div class="col-12 col-md-4 col-lg-4">
                    <a href="#" class="text-decoration-none mb-3 d-block">
                        <h3 class="fw-bold" style="color: var(--color-primary);">BatiKa.</h3>
                    </a>
                    <p class="text-white-50 small pe-lg-4">
                        Handcrafted Indonesian & Malaysian Batik bags designed for modern elegance. Preserving culture, one stitch at a time.
                    </p>
                    
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none border border-secondary">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none border border-secondary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none border border-secondary">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="social-icon d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none border border-secondary">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <h6 class="text-uppercase fw-bold mb-3 text-white ls-1">Shop</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">New Arrivals</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Best Sellers</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Tote Bags</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Clutches</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <h6 class="text-uppercase fw-bold mb-3 text-white ls-1">Support</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Help Center</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Shipping Info</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Returns</a></li>
                        <li><a href="#" class="footer-link text-white-50 text-decoration-none transition-all">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-3">
                    <h6 class="text-uppercase fw-bold mb-3 text-white ls-1">Stay Updated</h6>
                    <p class="text-white-50 small">Subscribe to get special offers and once-in-a-lifetime deals.</p>
                    
                    <form action="#" class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control bg-transparent text-white border-secondary" placeholder="Enter your email" aria-label="Email">
                            <button class="btn btn-primary text-white" type="button">Join</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="border-secondary my-4 opacity-50">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50 small">&copy; 2025 BatiKa, Inc. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <i class="bi bi-credit-card-2-front fs-4 text-white-50 mx-1"></i>
                    <i class="bi bi-paypal fs-4 text-white-50 mx-1"></i>
                    <i class="bi bi-bank fs-4 text-white-50 mx-1"></i>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 // Trigger when 15% of element is visible
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Run once
                    }
                });
            }, observerOptions);

            const animatedElements = document.querySelectorAll('.animate-on-scroll');
            animatedElements.forEach(el => observer.observe(el));
        });
    </script>

    <x-sweetalert-toast />
</body>
</html>