@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BatiKa E-Commerce | {{ $product->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Navbar Start -->
    <x-navbar></x-navbar>
    <!-- Navbar End -->


    <!-- Product Section Start -->
<section class="container py-5">

    <div class="row g-5 pt-5">

        <div class="col-12 col-lg-7">
            <div class="d-flex flex-column flex-md-row gap-3">
                
                <div class="d-flex flex-md-column gap-3 order-2 order-md-1 overflow-auto hide-scrollbar" style="max-height: 500px;">
                    <!-- Main Thumbnail as first option -->
                    <div class="thumbnail-item rounded-3 overflow-hidden active" 
                            style="width: 80px; height: 100px; min-width: 80px; cursor: pointer;">
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                    </div>
                    
                    <!-- Gallery Images -->
                    @foreach ($product->images as $img)
                        <div class="thumbnail-item rounded-3 overflow-hidden" 
                             style="width: 80px; height: 100px; min-width: 80px; cursor: pointer;">
                            <img src="{{ Storage::url($img->image_path) }}" class="w-100 h-100 object-fit-cover">
                        </div>
                    @endforeach
                </div>

                <div class="main-image-wrapper flex-grow-1 order-1 order-md-2 position-relative bg-light rounded-4 overflow-hidden">
                    @if($product->discount_price)
                    <span class="badge bg-danger position-absolute top-0 end-0 m-4 py-2 px-3 rounded-pill z-2">
                        Sale
                    </span>
                    @endif
                    <img src="{{ Storage::url($product->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}" style="min-height: 500px; max-height: 600px;">
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="sticky-product-details ps-lg-4" style="top: 100px;"> <div class="mb-4 border-bottom pb-4">
                    <h5 class="text-primary text-uppercase fw-bold fs-6 ls-2 mb-2">{{ $product->category->name }}</h5>
                    <h1 class="fw-bold display-5 text-dark mb-2">{{ $product->name }}</h1>
                    
                    <div class="d-flex align-items-center gap-3 mt-3">
                        @if($product->discount_price)
                            <h2 class="fw-bold mb-0" style="color: var(--color-text);">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</h2>
                            <span class="text-muted text-decoration-line-through fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <h2 class="fw-bold mb-0" style="color: var(--color-text);">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="d-flex text-warning small">
                            @php
                                $rating = $product->reviews_avg_rating ?? 0;
                                $count = $product->reviews_count ?? 0;
                            @endphp
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star{{ $i <= round($rating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="text-muted small border-start ps-2 ms-1">
                            @if($count > 0)
                                {{ number_format($rating, 1) }} ({{ $count }} Reviews)
                            @else
                                New Arrival
                            @endif
                        </span>
                    </div>
                </div>

                <p class="text-muted mb-4">
                    {{ $product->description }}
                </p>

                <div class="mb-4">
                    <label class="fw-semibold mb-2 d-block small text-uppercase ls-1">Color Options</label>
                    <div class="d-flex gap-2">
                        <div class="color-option active rounded-circle" style="background: #5D4037;"></div>
                        <div class="color-option rounded-circle" style="background: #C89D66;"></div>
                    </div>
                </div>

                <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST" class="d-flex gap-3 mb-4 align-items-stretch">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="quantity-box border rounded-pill d-flex align-items-center px-3" style="width: 120px;">
                        <button type="button" class="btn btn-sm border-0 p-0 fw-bold text-muted" onclick="decrementQty()">-</button>
                        <input type="text" name="quantity" id="qtyInput" class="form-control border-0 text-center bg-transparent fw-bold p-0" value="1" readonly>
                        <button type="button" class="btn btn-sm border-0 p-0 fw-bold text-primary" onclick="incrementQty()">+</button>
                    </div>

                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary rounded-pill flex-grow-1 py-3 fw-bold shadow-lg btn-buy">
                            <i class="bi bi-bag-fill me-2"></i> Add to Cart
                        </button>
                        
                        @if(auth()->check())
                             @php
                                $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first();
                            @endphp

                            @if($wishlistItem)
                                <button type="submit" form="wishlist-remove-form" class="btn btn-danger rounded-pill px-4 py-3 fw-bold shadow-lg d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart-fill text-white fs-5"></i>
                                </button>
                            @else
                                <button type="submit" form="wishlist-add-form" class="btn btn-outline-danger rounded-pill px-4 py-3 fw-bold shadow-lg d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart fs-5"></i>
                                </button>
                            @endif
                        @else
                             <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill px-4 py-3 fw-bold shadow-lg d-flex align-items-center justify-content-center">
                                <i class="bi bi-heart fs-5"></i>
                            </a>
                        @endif
                    </div>
                </form>

                @if(auth()->check())
                    <form id="wishlist-add-form" action="{{ route('wishlist.store') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </form>

                    @if($wishlistItem)
                        <form id="wishlist-remove-form" action="{{ route('wishlist.destroy', $wishlistItem->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif

                <div class="d-flex gap-3 mb-4 align-items-stretch">
                </div>
                

        </div>

    </div>
</section>
    <!-- Product Section End -->



<section class="container py-5">
    
    <div class="row g-5">
        
        <div class="col-12 col-lg-4">
            <div class="sticky-top" style="top: 120px; z-index: 1;">
                <h4 class="fw-bold mb-4">Product Information</h4>
                
                <div class="accordion accordion-flush" id="infoAccordion">
                    
                    <div class="accordion-item bg-transparent border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#specs" aria-expanded="true">
                                <i class="bi bi-rulers me-2 text-primary"></i> Specifications
                            </button>
                        </h2>
                        <div id="specs" class="accordion-collapse collapse show" data-bs-parent="#infoAccordion">
                            <div class="accordion-body text-muted small pt-0">
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    <li class="d-flex justify-content-between">
                                        <span>Material:</span> <span class="fw-medium text-dark">{{ $product->specifications['material'] ?? '-' }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Dimensions:</span> <span class="fw-medium text-dark">{{ $product->specifications['dimensions'] ?? '-' }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Strap Drop:</span> <span class="fw-medium text-dark">{{ $product->specifications['strap_drop'] ?? '-' }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Weight:</span> <span class="fw-medium text-dark">{{ $product->specifications['weight'] ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#care">
                                <i class="bi bi-droplet-half me-2 text-primary"></i> Care Instructions
                            </button>
                        </h2>
                        <div id="care" class="accordion-collapse collapse" data-bs-parent="#infoAccordion">
                            <div class="accordion-body text-muted small pt-0">
                                <p class="mb-2">To maintain the beauty of your Batik bag:</p>
                                <ul class="mb-0 ps-3">
                                    <li>Avoid direct sunlight when drying to prevent fading.</li>
                                    <li>Use a specialized leather cleaner for the strap.</li>
                                    <li>Do not machine wash. Spot clean with damp cloth only.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#shipping">
                                <i class="bi bi-box-seam me-2 text-primary"></i> Shipping & Returns
                            </button>
                        </h2>
                        <div id="shipping" class="accordion-collapse collapse" data-bs-parent="#infoAccordion">
                            <div class="accordion-body text-muted small pt-0">
                                Free shipping on all orders over Rp 1.000.000. Returns accepted within 30 days of delivery.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-12 col-lg-8">
            <h4 class="fw-bold mb-4">Customer Reviews</h4>

            <!-- Review Summary -->
            <div class="bg-light p-4 rounded-4 mb-5">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center border-end">
                        <h1 class="fw-bold display-4 mb-0 text-dark">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</h1>
                        <div class="text-warning mb-2">
                             @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star{{ $i <= round($product->reviews_avg_rating ?? 0) ? '-fill' : '' }}"></i>
                             @endfor
                        </div>
                        <p class="text-muted small mb-0">{{ $product->reviews_count ?? 0 }} Reviews</p>
                    </div>
                    <div class="col-md-8 ps-md-5">
                       <!-- Breakdown could go here -->
                       <p class="mb-0 text-muted">See what our customers have to say about the {{ $product->name }}.</p>
                    </div>
                </div>
            </div>

            <!-- Review List -->
             @forelse($product->reviews as $review)
            <div class="border-bottom pb-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center gap-3">
                        @if($review->user->avatar)
                             <img src="{{ Storage::url($review->user->avatar) }}" alt="{{ $review->user->name }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 48px; height: 48px;">
                        @else
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width: 48px; height: 48px;">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $review->user->name }}</h6>
                            <div class="text-warning small">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                
                @if($review->is_verified_purchase)
                    <div class="mb-2">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3"><i class="bi bi-patch-check-fill me-1"></i> Verified Purchase</span>
                    </div>
                @endif

                <p class="text-secondary mb-3">
                   {{ $review->comment }}
                </p>

                @if($review->image_path)
                    <div class="rounded-3 overflow-hidden" style="width: 100px; height: 100px;">
                         <img src="{{ Storage::url($review->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Review Image">
                    </div>
                @endif
            </div>
            @empty
             <div class="text-center p-5 border rounded-4 border-dashed mb-5">
                <i class="bi bi-chat-quote fs-1 text-muted mb-3 d-block opacity-25"></i>
                <p class="text-muted fw-medium">No reviews yet for this product.</p>
                <p class="small text-muted mb-0">Be the first to review!</p>
            </div>
            @endforelse

            <!-- Write Review Form -->
            @if(isset($canReview) && $canReview)
            <div class="card border-0 shadow-sm rounded-4 mt-5">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4">Write a Review</h5>
                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Rating</label>
                            <div class="rating-select d-flex gap-2 flex-row-reverse justify-content-end">
                                <input type="radio" class="btn-check" name="rating" id="star5" value="5" required>
                                <label class="btn btn-outline-warning border-0 fs-4 p-0" for="star5"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" class="btn-check" name="rating" id="star4" value="4">
                                <label class="btn btn-outline-warning border-0 fs-4 p-0" for="star4"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" class="btn-check" name="rating" id="star3" value="3">
                                <label class="btn btn-outline-warning border-0 fs-4 p-0" for="star3"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" class="btn-check" name="rating" id="star2" value="2">
                                <label class="btn btn-outline-warning border-0 fs-4 p-0" for="star2"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" class="btn-check" name="rating" id="star1" value="1">
                                <label class="btn btn-outline-warning border-0 fs-4 p-0" for="star1"><i class="bi bi-star-fill"></i></label>
                            </div>
                            <style>
                                /* Reset Bootstrap Button Styles for Rating */
                                .rating-select .btn-check:checked + .btn,
                                .rating-select .btn.active,
                                .rating-select .btn:active,
                                .rating-select .btn:hover {
                                    background-color: transparent !important;
                                    border-color: transparent !important;
                                    color: inherit;
                                    box-shadow: none !important;
                                }

                                /* Star Color Logic */
                                .rating-select input:checked ~ label i,
                                .rating-select label:hover i,
                                .rating-select label:hover ~ label i { color: #ffc107; }
                                .rating-select label i { color: #ddd; transition: color 0.2s; }
                            </style>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold small text-uppercase">Your Review</label>
                            <textarea class="form-control bg-light border-0 rounded-4 p-3" id="comment" name="comment" rows="4" placeholder="Tell us what you think about this product..." required></textarea>
                        </div>

                        <div class="mb-4">
                             <label for="image" class="form-label fw-bold small text-uppercase">Add Photo (Optional)</label>
                             <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-3 fw-bold w-100">Submit Review</button>
                    </form>
                </div>
            </div>
            @endif

        </div>

    </div>

</section>
    <!-- Description Section End -->

    <x-sweetalert-toast />
</body>
</html>
