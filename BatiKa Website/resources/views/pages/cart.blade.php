<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Your Cart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-5">
        
        <div class="mb-4">
            <h1 class="display-6 fw-bold text-dark">Shopping Cart</h1>
            <p class="text-muted">You have <span class="fw-bold text-primary">{{ $cartItems->count() }} items</span> in your cart</p>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="mb-3 d-lg-none">
                    <a href="/collections" class="text-muted text-decoration-none small fw-bold hov-primary">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                    </a>
                </div>

                @if($cartItems->count() > 0)
                    <div class="d-flex justify-content-between text-muted small text-uppercase ls-1 mb-3 px-4 align-items-center">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <input type="checkbox" class="form-check-input" id="select-all" onclick="toggleAll(this)" checked>
                            <span>Select All</span>
                        </div>
                        <span style="width: 20%;" class="text-center d-none d-lg-block">Quantity</span>
                        <span style="width: 20%;" class="text-end d-none d-lg-block">Price</span>
                        <span style="width: 5%;" class="d-none d-lg-block"></span>
                    </div>

                    <form id="cart-form" action="{{ route('cart.checkout') }}" method="POST">
                        @csrf

                    @foreach($cartItems as $item)
                    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden cart-item">
                        <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-center gap-4">
                            
                            <div class="d-flex align-items-center gap-3 flex-grow-1 w-100 w-md-auto">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="form-check-input cart-checkbox flex-shrink-0" onclick="updateTotal()" checked>

                                <div class="bg-light rounded-3 overflow-hidden flex-shrink-0 position-relative" style="width: 100px; height: 100px;">
                                    <img src="{{ Storage::url($item->product->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->product->name }}">
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1 fs-6 fs-md-5">{{ $item->product->name }}</h5>
                                    <div class="text-muted small mb-2">{{ $item->product->category->name }}</div>
                                    <div class="d-md-none fw-bold text-primary item-total-price" data-id="{{ $item->id }}">
                                        Rp {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center w-100 w-md-auto gap-3 justify-content-md-center" style="min-width: 140px;">
                                
                                <div class="d-flex align-items-center border rounded-pill overflow-hidden flex-grow-1 flex-md-grow-0" style="width: fit-content;">
                                    <button type="button" class="btn btn-white px-3 border-0 text-muted" onclick="updateQty(this, -1)">-</button>
                                    <input type="number" name="quantities[{{ $item->id }}]" class="form-control text-center border-0 bg-white fw-bold p-0 cart-qty-input" 
                                           value="{{ $item->quantity }}" readonly style="width: 50px;" 
                                           data-price="{{ $item->product->discount_price ?? $item->product->price }}">
                                    <button type="button" class="btn btn-white px-3 border-0 text-muted" onclick="updateQty(this, 1)">+</button>
                                </div>


                            </div>

                            <div class="text-end d-none d-md-block" style="min-width: 100px;">
                                <h5 class="fw-bold text-primary mb-0 item-total-price text-nowrap" data-id="{{ $item->id }}">
                                    Rp {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}
                                </h5>
                            </div>

                            <div class="d-none d-md-block text-end">
                                <button type="submit" form="delete-form-{{ $item->id }}" class="btn btn-light rounded-circle text-muted hover-danger shadow-sm" style="width: 38px; height: 38px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    @endforeach
                    </form>

                    {{-- Hidden Delete Forms --}}
                    @foreach($cartItems as $item)
                        <form id="delete-form-{{ $item->id }}" action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted opacity-25 mb-3 d-block"></i>
                        <h4 class="fw-bold text-muted">Your cart is empty</h4>
                        <a href="/collections" class="btn btn-primary rounded-pill mt-3 px-4 fw-bold">Start Shopping</a>
                    </div>
                @endif

                <div class="mt-4 d-none d-lg-block">
                    <a href="/collections" class="text-muted text-decoration-none small fw-bold hov-primary">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                    </a>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="sticky-summary">
                    
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Cart Summary</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold" id="cart-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="text-muted fst-italic small">Calculated at checkout</span>
                        </div>

                        <hr class="border-secondary opacity-10 my-4">

                        <div class="d-flex justify-content-between mb-4 align-items-center">
                            <span class="text-dark fw-bold fs-5">Total</span>
                            <span class="text-primary fw-bold fs-3" id="cart-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" form="cart-form" id="checkout-btn" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 btn-buy mb-3">
                            Proceed to Checkout
                        </button>

                        <div class="mt-3">
                            <a class="text-decoration-none text-dark small fw-bold d-flex align-items-center" data-bs-toggle="collapse" href="#promoCode" role="button">
                                <i class="bi bi-tag me-2 text-primary"></i> Have a promo code?
                            </a>
                            <div class="collapse mt-2" id="promoCode">
                                <div class="input-group">
                                    <input type="text" class="form-control border-end-0" placeholder="Enter code" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                                    <button class="btn btn-outline-secondary border-start-0 text-primary fw-bold" type="button" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">Apply</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-center">
                            <div class="d-flex gap-2 justify-content-center opacity-50 grayscale-icons">
                                <i class="bi bi-credit-card-2-front fs-4" title="Visa"></i>
                                <i class="bi bi-paypal fs-4" title="Paypal"></i>
                                <i class="bi bi-shield-check fs-4" title="Secure"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <x-footer></x-footer>

    <script>
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = source.checked;
            });
            updateTotal();
        }

        function updateQty(btn, change) {
            const input = btn.parentElement.querySelector('input');
            let newValue = parseInt(input.value) + change;
            if (newValue >= 1) {
                input.value = newValue;
                updateTotal();
            }
        }

        function updateTotal() {
            let total = 0;
            let count = 0;
            const itemRows = document.querySelectorAll('.cart-item');
            
            itemRows.forEach(row => {
                const checkbox = row.querySelector('.cart-checkbox');
                if(checkbox && checkbox.checked) {
                    const input = row.querySelector('.cart-qty-input');
                    const qty = parseInt(input.value);
                    const price = parseFloat(input.getAttribute('data-price'));
                    total += qty * price;
                    count++;
                }

                // Update per-item price display
                const input = row.querySelector('.cart-qty-input');
                const qty = parseInt(input.value);
                const price = parseFloat(input.getAttribute('data-price'));
                const itemTotal = qty * price;

                const itemId = input.name.match(/\[(.*?)\]/)[1];
                const itemPriceElements = document.querySelectorAll(`.item-total-price[data-id="${itemId}"]`);
                itemPriceElements.forEach(el => {
                    el.innerText = 'Rp ' + itemTotal.toLocaleString('id-ID');
                });
            });

            const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('cart-subtotal').innerText = formattedTotal;
            document.getElementById('cart-total').innerText = formattedTotal;

             // Handle checkout button state
            const checkoutBtn = document.getElementById('checkout-btn');
            if(checkoutBtn) {
                 if(count === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.classList.add('opacity-50');
                } else {
                    checkoutBtn.disabled = false;
                    checkoutBtn.classList.remove('opacity-50');
                }
            }
           

            // Sync select-all checkbox
            const allCheckboxes = document.querySelectorAll('.cart-checkbox');
            if (allCheckboxes.length > 0) {
                const allChecked = Array.from(allCheckboxes).every(c => c.checked);
                const selectAllCb = document.getElementById('select-all');
                if(selectAllCb) selectAllCb.checked = allChecked;
            }
        }
        
         // Initialize total on load
        document.addEventListener('DOMContentLoaded', updateTotal);
    </script>
    <x-sweetalert-toast />
</body>
</html>