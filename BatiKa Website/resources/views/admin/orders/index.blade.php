<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-circle shadow-sm border" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="h4 fw-bold mb-0 text-dark">
                    {{ __('Orders') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-0 mb-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase ls-1">
                            <th class="py-3 px-4 border-bottom-0 d-none d-md-table-cell">Order ID</th>
                            <th class="py-3 px-4 border-bottom-0">Customer</th>
                            <th class="py-3 px-4 border-bottom-0">Status</th>
                            <th class="py-3 px-4 border-bottom-0 d-none d-sm-table-cell">Total</th>
                            <th class="py-3 px-4 border-bottom-0 d-none d-lg-table-cell">Date</th>
                            <th class="py-3 px-4 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 fw-bold d-none d-md-table-cell">
                                #{{ $order->order_number }}
                            </td>
                            <td class="px-4 py-3">
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
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
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
                            <td class="px-4 py-3 fw-bold d-none d-sm-table-cell">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-muted small d-none d-lg-table-cell">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-top">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
