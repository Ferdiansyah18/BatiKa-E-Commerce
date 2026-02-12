<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Shop Collections</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .active-ring {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }
    </style>
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-4">
        <div class="d-flex flex-column align-items-center text-center mb-5">
            <h1 class="display-5 fw-bold text-dark mb-2">Shop Collections</h1>
            <p class="text-muted col-lg-6">
                Explore our exclusive range of handcrafted batik bags, where tradition meets modern elegance.
            </p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="btn btn-outline-dark rounded-pill d-lg-none px-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <i class="bi bi-sliders me-2"></i> Filter
            </button>
            
            <span class="text-muted d-none d-lg-block">
                Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
            </span>

<div class="d-flex align-items-center gap-2">
    <span class="text-muted small d-none d-md-block">Sort by:</span>
    
    <div class="dropdown">
        <button class="btn btn-white border rounded-pill px-4 py-2 fw-medium d-flex align-items-center gap-3 shadow-sm dropdown-toggle custom-dropdown-btn" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            {{ request('sort') ? ucfirst(str_replace('_', ' ', request('sort'))) : 'Newest Arrivals' }}
        </button>
        
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2 p-2" style="min-width: 200px;">
            <li><a class="dropdown-item rounded-3 mb-1 {{ request('sort') == 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrivals</a></li>
            <li><a class="dropdown-item rounded-3 mb-1 {{ request('sort') == 'price_asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
            <li><a class="dropdown-item rounded-3 mb-1 {{ request('sort') == 'price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
            <li><a class="dropdown-item rounded-3 {{ request('sort') == 'oldest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest</a></li>
        </ul>
    </div>
</div>
        </div>
    </section>

    <section class="container pb-5 mb-5">
        <div class="row g-4">
            
            <div class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start bg-light p-3 rounded" tabindex="-1" id="filterSidebar">
                    
                    <div class="offcanvas-header bg-white border-bottom">
                        <h5 class="offcanvas-title fw-bold">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('collections') }}" method="GET" id="filterForm">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="offcanvas-body p-0 d-flex flex-column gap-4">
                            
                            {{-- Categories Filter --}}
                            <div class="filter-group">
                                <h6 class="fw-bold mb-3 ls-1 text-uppercase small">Categories</h6>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($categories as $category)
                                    <label class="custom-check d-flex align-items-center justify-content-between cursor-pointer">
                                        <span>{{ $category->name }}</span>
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <span class="checkmark"></span>
                                        <small class="text-muted">({{ $category->products_count }})</small>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="border-secondary opacity-25 my-0">

                            {{-- Price Filter --}}
                            <div class="filter-group">
                                <h6 class="fw-bold mb-3 ls-1 text-uppercase small">Price Range</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                                    <span>-</span>
                                    <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm w-100 mt-2">Apply</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    
                    @forelse ($products as $product)
                    <div class="col">
                        <div class="product-card card border-0 rounded-4 overflow-hidden h-100">
                            
                            <div class="product-image-wrapper position-relative overflow-hidden bg-light">
                                {{-- Badges Logic --}}
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 z-2">Featured</span>
                                @elseif($product->created_at->diffInDays(now()) < 7)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 z-2">New</span>
                                @endif

                                {{-- Image --}}
                                <img src="{{ Storage::url($product->thumbnail) }}" class="card-img-top w-100" alt="{{ $product->name }}">
                                
                                <div class="overlay-actions d-none d-lg-flex justify-content-center align-items-center gap-2">
                                    {{-- Add to Cart Form (Optional: can be added later) --}}
                                    <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-light rounded-circle shadow-sm icon-btn" title="View Details">
                                        <i class="bi bi-eye text-dark"></i>
                                    </a>
                                </div>
                                <a href="{{ route('product.detail', $product->slug) }}" class="stretched-link d-lg-none"></a>
                            </div>
    
                            <div class="card-body text-center p-4">
                                <div class="text-warning small mb-2">
                                    @php
                                        $rating = $product->reviews_avg_rating ?? 0;
                                    @endphp
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi bi-star{{ $i <= round($rating) ? '-fill' : '' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-1">({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                                <h5 class="card-title fw-bold mb-1">
                                    <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none text-dark d-none d-lg-block stretched-link">{{ $product->name }}</a>
                                    <span class="d-lg-none text-dark">{{ $product->name }}</span>
                                </h5>
                                <p class="text-muted small mb-2">{{ $product->category->name ?? 'Collection' }}</p>
                                
                                @if($product->discount_price)
                                    <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</h4>
                                    <small class="text-decoration-line-through text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                @else
                                    <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center">
                        <p class="text-muted">No products found.</p>
                    </div>
                    @endforelse

                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {!! $products->links() !!}
                </div>

            </div>
        </div>
    </section>

    <x-footer></x-footer>

    <x-sweetalert-toast />
</body>
</html>