<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 fw-bold mb-0 text-dark">{{ __('Dashboard') }}</h2>
                <p class="mb-0 text-muted small">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light border shadow-sm rounded-pill btn-sm px-3">
                    <i class="bi bi-download me-2"></i> Export Report
                </button>
                <form method="POST" action="{{ route('logout') }}" id="logout-form-dashboard">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger shadow-sm rounded-pill btn-sm px-3">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </x-slot>



    <!-- 1. Statistics Cards -->
    <div class="row g-4 mb-5">
        <!-- Revenue -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                            <i class="bi bi-arrow-up-short"></i> {{ $stats['revenue_growth'] }}%
                        </span>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small ls-1 mb-1">Total Revenue</h6>
                        <h3 class="fw-bold fs-4 mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                            <i class="bi bi-basket fs-4"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                            <i class="bi bi-arrow-up-short"></i> {{ $stats['orders_growth'] }}%
                        </span>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small ls-1 mb-1">Total Orders</h6>
                        <h3 class="fw-bold fs-4 mb-0">{{ $stats['total_orders'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Sold -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                            <i class="bi bi-shop fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small ls-1 mb-1">Products Sold</h6>
                        <h3 class="fw-bold fs-4 mb-0">{{ $stats['products_sold'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px;">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">
                            +{{ $stats['new_customers'] }} New
                        </span>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small ls-1 mb-1">Total Customers</h6>
                        <h3 class="fw-bold fs-4 mb-0">1,240</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- 2. Sales Chart (Real Chart.js) -->
        <div class="col-lg-8">


            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-3 px-md-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="fw-bold mb-0 text-dark">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none small fw-bold text-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-3 ps-md-4 rounded-start d-none d-md-table-cell">Order ID</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 d-none d-sm-table-cell">Total</th>
                                    <th class="border-0 pe-3 pe-md-4 rounded-end text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordersToProcess as $order)
                                <tr>
                                    <td class="ps-3 ps-md-4 fw-bold d-none d-md-table-cell">#{{ $order->order_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($order->user && $order->user->avatar)
                                                <img src="{{ Storage::url($order->user->avatar) }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 32px; height: 32px;" alt="{{ $order->user->name }}">
                                            @else
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ substr($order->user->name ?? 'G', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $order->user->name ?? 'Guest' }}</div>
                                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $order->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Processing</span>
                                        @elseif($order->status == 'on_delivery')
                                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">On Delivery</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Delivered</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold d-none d-sm-table-cell">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="pe-3 pe-md-4 text-end">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary rounded-pill px-3">Process</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No incoming orders to process.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Recent Feedback -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Feedback</h5>
                    <a href="#" class="text-decoration-none small fw-bold text-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush pt-2">
                        @foreach($feedback as $item)
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">{{ $item['avatar'] }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-semibold fs-6">{{ $item['customer_name'] }}</h6>
                                        <span class="text-muted small" style="font-size: 0.75rem;">{{ $item['date'] }}</span>
                                    </div>
                                    <div class="mb-1 text-warning small">
                                        @for($i = 0; $i < $item['rating']; $i++) <i class="bi bi-star-fill"></i> @endfor
                                        @for($i = $item['rating']; $i < 5; $i++) <i class="bi bi-star text-muted opacity-25"></i> @endfor
                                    </div>
                                    <p class="mb-1 text-muted small text-truncate" style="max-width: 200px;">
                                        "{{ $item['comment'] }}"
                                    </p>
                                    <div class="small fw-medium text-primary bg-primary bg-opacity-10 rounded px-2 py-1 d-inline-block">
                                        {{ $item['product_name'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
    
    <div class="mb-5"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
             // Dashboard Logout Confirmation
            const logoutForm = document.getElementById('logout-form-dashboard');
            if(logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will be logged out of your session.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#C89D66',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
