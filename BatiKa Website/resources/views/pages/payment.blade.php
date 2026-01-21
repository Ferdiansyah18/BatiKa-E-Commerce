<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Secure Checkout</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-5">
        
        <div class="text-center mb-5">
            <h1 class="display-6 fw-bold text-dark mb-2">Checkout</h1>
            <p class="text-muted">Complete your details to finish the order.</p>
        </div>

        <form action="{{ route('order.store') }}" method="POST" class="row g-5">
            @csrf
            
            <input type="hidden" name="payment_method" value="midtrans">

            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="fw-bold m-0">Shipping Details</h5>
                    </div>

                    <div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Full Name" value="{{ auth()->user()->name ?? '' }}" required>
                                    <label for="fullName">Full Name</label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ auth()->user()->email ?? '' }}" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <!-- Address Fields Auto-Populated if Primary Exists -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Street Address" value="{{ $primaryAddress->address_line ?? '' }}" required>
                                    <label for="address">Street Address</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{ $primaryAddress->city ?? '' }}" required>
                                    <label for="city">City / District</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="zip" name="postal_code" placeholder="Zip Code" value="{{ $primaryAddress->postal_code ?? '' }}" required>
                                    <label for="zip">Zip Code</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-summary">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        <div class="overflow-auto pe-2" style="max-height: 300px;">
                            
                            @foreach($checkoutItems as $item)
                            <div class="d-flex gap-3 mb-3 align-items-center">
                                <div class="bg-light rounded-3 overflow-hidden" style="width: 70px; height: 70px;">
                                    <img src="{{ Storage::url($item->product->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->product->name }}">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-0 fs-6">{{ $item->product->name }}</h6>
                                    <small class="text-muted">Category: {{ $item->product->category->name }}</small>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">x{{ $item->quantity }}</small>
                                        <small class="fw-bold">Rp {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-bold text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 align-items-center">
                            <span class="text-dark fw-bold fs-5">Total</span>
                            <span class="text-primary fw-bold fs-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 btn-buy">
                            Complete Payment <i class="bi bi-arrow-right"></i>
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted d-flex align-items-center justify-content-center gap-1">
                                <i class="bi bi-shield-lock-fill"></i> Secure Encrypted Payment
                            </small>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </section>

    <x-footer></x-footer>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const checkoutForm = document.querySelector('form');
        const payBtn = document.querySelector('.btn-buy');

        checkoutForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Disable button
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            const formData = new FormData(checkoutForm);

            try {
                const response = await fetch("{{ route('order.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Trigger Snap Popup
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            window.location.href = data.redirect_url;
                        },
                        onPending: function(result){
                            window.location.href = "{{ route('dashboard') }}";
                        },
                        onError: function(result){
                            alert("Payment failed!");
                            window.location.href = "{{ route('dashboard') }}";
                        },
                        onClose: function(){
                            alert('You closed the popup without finishing the payment');
                            window.location.href = "{{ route('dashboard') }}";
                        }
                    });
                } else if (!response.ok) {
                   // Handle validation errors or server errors
                   alert('Error: ' + (data.message || 'Something went wrong'));
                   payBtn.disabled = false;
                   payBtn.innerHTML = 'Complete Payment <i class="bi bi-arrow-right"></i>';
                }

            } catch (error) {
                console.error(error);
                alert('An error occurred. Please try again.');
                payBtn.disabled = false;
                payBtn.innerHTML = 'Complete Payment <i class="bi bi-arrow-right"></i>';
            }
        });
    </script>
</body>
</html>