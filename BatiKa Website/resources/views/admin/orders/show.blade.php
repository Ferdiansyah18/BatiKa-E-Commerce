<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light rounded-circle shadow-sm border" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="h4 fw-bold mb-0 text-dark">
                    Order #{{ $order->order_number }}
                </h2>
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
            </div>
        </div>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-secondary small text-uppercase ls-1">
                                    <th class="ps-4 border-bottom-0">Product</th>
                                    <th class="border-bottom-0">Price</th>
                                    <th class="border-bottom-0">Qty</th>
                                    <th class="pe-4 border-bottom-0 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-3" style="width: 60px; height: 60px; overflow: hidden;">
                                                @if($item->product->thumbnail)
                                                    <img src="{{ Storage::url($item->product->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                        <i class="bi bi-image fs-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $item->product->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-3">x{{ $item->quantity }}</td>
                                    <td class="pe-4 py-3 text-end fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="ps-4 py-3 text-end fw-bold">Total Amount</td>
                                    <td class="pe-4 py-3 text-end fw-bold fs-5 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Shipping Information</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        // Order model casts shipping_address to array, so it is already an array (or null).
                        // Check if it's an array, otherwise default to empty array.
                        $shipping = is_array($order->shipping_address) ? $order->shipping_address : [];
                    @endphp
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1 mb-1">Recipient Name</label>
                            <p class="fw-medium mb-0">{{ $shipping['name'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1 mb-1">Phone Number</label>
                            <p class="fw-medium mb-0">{{ $shipping['phone'] ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold ls-1 mb-1">Address</label>
                            <p class="fw-medium mb-0">{{ $shipping['address'] ?? '-' }}</p>
                            <p class="fw-medium mb-0">{{ $shipping['city'] ?? '-' }}, {{ $shipping['postal_code'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Customer Info -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Customer</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($order->user && $order->user->avatar)
                            <img src="{{ Storage::url($order->user->avatar) }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 50px; height: 50px;" alt="{{ $order->user->name }}">
                        @else
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $order->user->name ?? 'Guest' }}</h6>
                            <p class="text-muted small mb-0">{{ $order->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="bi bi-clock"></i>
                        Ordered {{ $order->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Update Status</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @if($order->status == 'pending')
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <small class="fw-bold">Pending orders cannot be modified.</small>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label text-muted small text-uppercase fw-bold ls-1">Order Status</label>
                                <select class="form-select" name="status">
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="on_delivery" {{ $order->status == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            


                            <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                                Update Status
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
