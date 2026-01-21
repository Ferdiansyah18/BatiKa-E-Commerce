<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Shop Collections</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            
            <span class="text-muted d-none d-lg-block">Showing 1-9 of 24 results</span>

<div class="d-flex align-items-center gap-2">
    <span class="text-muted small d-none d-md-block">Sort by:</span>
    
    <div class="dropdown">
        <button class="btn btn-white border rounded-pill px-4 py-2 fw-medium d-flex align-items-center gap-3 shadow-sm dropdown-toggle custom-dropdown-btn" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            Newest Arrivals
        </button>
        
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2 p-2" style="min-width: 200px;">
            <li><a class="dropdown-item active rounded-3 mb-1" href="#">Newest Arrivals</a></li>
            <li><a class="dropdown-item rounded-3 mb-1" href="#">Price: Low to High</a></li>
            <li><a class="dropdown-item rounded-3 mb-1" href="#">Price: High to Low</a></li>
            <li><a class="dropdown-item rounded-3" href="#">Popularity</a></li>
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

                    <div class="offcanvas-body p-0 d-flex flex-column gap-4">
                        
                        <div class="filter-group">
                            <h6 class="fw-bold mb-3 ls-1 text-uppercase small">Categories</h6>
                            <div class="d-flex flex-column gap-2">
                                <label class="custom-check d-flex align-items-center justify-content-between cursor-pointer">
                                    <span>Tote Bags</span>
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                    <small class="text-muted">(12)</small>
                                </label>
                                <label class="custom-check d-flex align-items-center justify-content-between cursor-pointer">
                                    <span>Clutches</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <small class="text-muted">(8)</small>
                                </label>
                                <label class="custom-check d-flex align-items-center justify-content-between cursor-pointer">
                                    <span>Backpacks</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <small class="text-muted">(4)</small>
                                </label>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-25 my-0">

                        <div class="filter-group">
                            <h6 class="fw-bold mb-3 ls-1 text-uppercase small">Colors</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="color-option active rounded-circle" style="background: #5D4037;" title="Brown"></div>
                                <div class="color-option rounded-circle" style="background: #1A1A1A;" title="Black"></div>
                                <div class="color-option rounded-circle" style="background: #C89D66;" title="Gold"></div>
                                <div class="color-option rounded-circle" style="background: #8D6E63;" title="Taupe"></div>
                                <div class="color-option rounded-circle border bg-white" title="White"></div>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-25 my-0">

                        <div class="filter-group">
                            <h6 class="fw-bold mb-3 ls-1 text-uppercase small">Price</h6>
                            <input type="range" class="form-range" min="0" max="500" id="priceRange" style="color: var(--color-primary);">
                            <div class="d-flex justify-content-between small fw-bold text-dark mt-2">
                                <span>$0</span>
                                <span>$500+</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    
                    @for ($i = 0; $i < 9; $i++)
                    <div class="col">
                        <div class="product-card card border-0 rounded-4 overflow-hidden h-100">
                            
                            <div class="product-image-wrapper position-relative overflow-hidden bg-light">
                                @if($i === 0 || $i === 3)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 z-2">New</span>
                                @elseif($i === 2)
                                    <span class="badge bg-dark position-absolute top-0 start-0 m-3 z-2">Sold Out</span>
                                @endif
                                
                                <img src="{{ asset('images/tas-1.jpg') }}" class="card-img-top w-100" alt="Product Name">
                                
                                <div class="overlay-actions d-none d-lg-flex justify-content-center align-items-center gap-2">
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm icon-btn" title="Add to Cart">
                                        <i class="bi bi-cart-plus text-dark"></i>
                                    </a>
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm icon-btn" title="View Details">
                                        <i class="bi bi-eye text-dark"></i>
                                    </a>
                                </div>
                                <a href="#" class="stretched-link d-lg-none"></a>
                            </div>
    
                            <div class="card-body text-center p-4">
                                <div class="text-warning small mb-2">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-1">
                                    <a href="#" class="text-decoration-none text-dark d-none d-lg-block stretched-link">Batik Tote {{ $i+1 }}</a>
                                    <span class="d-lg-none text-dark">Batik Tote {{ $i+1 }}</span>
                                </h5>
                                <p class="text-muted small mb-2">Premium Series</p>
                                <h4 class="text-primary fw-bold mb-0">$120.00</h4>
                            </div>
                        </div>
                    </div>
                    @endfor

                </div>

                <div class="mt-5 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination gap-2">
                            <li class="page-item disabled">
                                <a class="page-link rounded-circle d-flex align-items-center justify-content-center" href="#" tabindex="-1"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link rounded-circle d-flex align-items-center justify-content-center" href="#">1</a></li>
                            <li class="page-item"><a class="page-link rounded-circle d-flex align-items-center justify-content-center" href="#">2</a></li>
                            <li class="page-item"><a class="page-link rounded-circle d-flex align-items-center justify-content-center" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link rounded-circle d-flex align-items-center justify-content-center" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </section>

    <x-footer></x-footer>

    <x-sweetalert-toast />
</body>
</html>