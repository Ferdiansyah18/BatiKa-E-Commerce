<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} | The Story - BatiKa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <x-navbar textColor="text-white"></x-navbar>

    {{-- Hero Section --}}
    <section class="position-relative d-flex align-items-center justify-content-center overflow-hidden" 
             style="height: 60vh; min-height: 400px;">
        
        {{-- Parallax Background --}}
        <div class="parallax-bg position-absolute top-0 start-0 w-100" 
             style="height: 120%; top: -10%; background: url('{{ $category->image ? Storage::url($category->image) : asset('images/about-us-img.jpg') }}') center/cover no-repeat; z-index: 0;">
        </div>

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 z-1"></div>
        
        <div class="container position-relative z-2 text-center text-white">
            <span class="text-uppercase fw-bold ls-2 mb-3 d-block animate-on-scroll">BatiKa Collection</span>
            <h1 class="display-3 fw-bold mb-4 animate-on-scroll delay-100">{{ $category->name }}</h1>
            <div class="d-flex justify-content-center animate-on-scroll delay-200">
                <i class="bi {{ $category->icon ?? 'bi-bag' }} fs-1"></i>
            </div>
        </div>
    </section>

    {{-- Story Section --}}
    <section class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h6 class="text-primary fw-bold text-uppercase ls-2 mb-4 animate-on-scroll">The Story Behind</h6>
                <div class="lead text-muted lh-lg mb-5 animate-on-scroll delay-100">
                    @if($category->description)
                        {!! nl2br(e($category->description)) !!}
                    @else
                        <p>Currently, there is no detailed story for this collection. However, each piece is crafted with the same dedication and passion that defines BatiKa.</p>
                    @endif
                </div>
                <hr class="w-25 mx-auto border-secondary opacity-25">
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="container pb-5 mb-5">
        <div class="text-center mb-5 animate-on-scroll">
            <h2 class="fw-bold">Explore the Collection</h2>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $product)
                {{-- Product Card --}}
                <div class="col animate-on-scroll delay-100">
                     <div class="product-card card border-0 rounded-4 overflow-hidden h-100 shadow-sm group">
                        <div class="product-image-wrapper position-relative overflow-hidden bg-light" style="aspect-ratio: 1/1;">
                            <img src="{{ Storage::url($product->thumbnail) }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                            <a href="{{ route('product.detail', $product->slug) }}" class="stretched-link"></a>
                        </div>
                        <div class="card-body p-3 text-center">
                             <div class="text-warning small mb-1">
                                <i class="bi bi-star-fill"></i> <span class="text-muted">({{ $product->reviews_count }})</span>
                             </div>
                             <h6 class="card-title fw-bold mb-1 text-truncate">{{ $product->name }}</h6>
                             <div class="text-primary fw-bold">
                                Rp {{ number_format($product->current_price, 0, ',', '.') }}
                             </div>
                        </div>
                     </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found in this collection yet.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </section>

    <x-footer></x-footer>
    <x-sweetalert-toast />
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

            // Parallax Effect
            const parallaxBg = document.querySelector('.parallax-bg');
            if(parallaxBg) {
                window.addEventListener('scroll', () => {
                    const scrolled = window.pageYOffset;
                    // Move background at 40% speed of scroll
                    parallaxBg.style.transform = `translateY(${scrolled * 0.4}px)`;
                });
            }
        });
    </script>
</body>
</html>
