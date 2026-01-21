<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatiKa | Complete Payment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Midtrans Snap -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                    <div class="mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-wallet2 fs-2"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold mb-2">Complete Your Payment</h2>
                    <p class="text-muted mb-4">Order #{{ $order->order_number }}</p>
                    
                    <h1 class="fw-bold text-primary mb-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h1>

                    <div class="d-grid gap-3">
                        <button id="pay-button" class="btn btn-primary rounded-pill py-3 fw-bold fs-5 shadow-sm">
                            Pay Now
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill py-3 fw-bold">
                            I'll Pay Later
                        </a>
                    </div>

                    <div class="mt-4 text-muted small">
                        <i class="bi bi-shield-lock-fill me-1"></i> Secure payment by Midtrans
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer></x-footer>

    <script type="text/javascript">

      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        console.log('Pay button clicked');
        var snapToken = '{{ $order->snap_token }}';
        if (!snapToken) {
            alert('Error: Snap Token is missing. Please check your API Keys or try again.');
            return;
        }
        
        snap.pay(snapToken, {
          onSuccess: function(result){
            /* You may add your own implementation here */
            // alert("payment success!"); 
            window.location.href = "{{ route('payment.success', ['order' => $order]) }}";
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); 
            window.location.href = "{{ route('dashboard') }}";
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); 
             window.location.href = "{{ route('dashboard') }}";
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
        })
      });
    </script>
</body>
</html>
