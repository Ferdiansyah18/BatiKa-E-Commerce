<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BatiKa | My Account</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--color-bg);">

    <x-navbar></x-navbar> 

    <section class="container pt-5 mt-5 pb-5">
        
        <div class="mb-5">
            <h1 class="display-6 fw-bold text-dark mb-1">My Account</h1>
            <p class="text-muted">Welcome back, <span class="fw-bold text-primary">{{ Auth::user()->name }}</span></p>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        
                        <div class="p-4 text-center bg-light-custom border-bottom">
                            <div class="position-relative d-inline-block mb-3">
                                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=C89D66&color=fff' }}" class="rounded-circle border border-3 border-white shadow-sm" width="80" height="80" alt="Profile">
                            </div>
                            <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">Member since {{ Auth::user()->created_at->format('Y') }}</small>
                        </div>

                        <div class="list-group list-group-flush py-2" id="accountTabs" role="tablist">
                            <a class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0 active" id="dashboard-tab" data-bs-toggle="pill" href="#dashboard" role="tab">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0 position-relative" id="orders-tab" data-bs-toggle="pill" href="#orders" role="tab" onclick="markOrdersAsSeen()">
                                <i class="bi bi-bag-check-fill"></i> My Orders
                                @if($unseenOrdersCount > 0)
                                    <span id="new-order-bubble" class="badge bg-danger rounded-pill ms-2">New</span>
                                @endif
                                @if($inProgressCount > 0)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill ms-auto">{{ $inProgressCount }}</span>
                                @endif
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0" id="address-tab" data-bs-toggle="pill" href="#address" role="tab">
                                <i class="bi bi-geo-alt-fill"></i> Address Book
                            </a>
    <a class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0" id="profile-tab" data-bs-toggle="pill" href="#profile" role="tab">
                                <i class="bi bi-person-lines-fill"></i> Account Details
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0" id="wishlist-tab" data-bs-toggle="pill" href="#wishlist" role="tab">
                                <i class="bi bi-heart-fill"></i> My Wishlist
                            </a>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-account">
                                @csrf
                                <button type="submit" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4 border-0 text-danger bg-transparent w-100">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ... (rest of the file remains unchanged, I will use line numbers to target specific blocks) ... -->
            
            <div class="col-lg-9">
                <div class="tab-content" id="accountTabsContent">
                    
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                                    <div class="card-body p-4 d-flex align-items-center gap-3">
                                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                            <i class="bi bi-hourglass-split fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">In Progress</small>
                                            <h4 class="fw-bold mb-0">{{ $inProgressCount }} Order{{ $inProgressCount != 1 ? 's' : '' }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                                    <div class="card-body p-4 d-flex align-items-center gap-3">
                                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                            <i class="bi bi-check-circle fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Completed</small>
                                            <h4 class="fw-bold mb-0">{{ $completedCount }} Order{{ $completedCount != 1 ? 's' : '' }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                                    <div class="card-body p-4 d-flex align-items-center gap-3">
                                        <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                            <i class="bi bi-heart fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Wishlist</small>
                                            <h4 class="fw-bold mb-0">{{ $wishlists->count() }} Items</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Recent Orders</h5>
                                <a href="#" class="text-primary fw-bold text-decoration-none small" onclick="switchTab('orders-tab')">View All</a>
                            </div>
                            <div class="card-body p-0">
                                @if(isset($dashboardRecentOrders) && $dashboardRecentOrders->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($dashboardRecentOrders as $recentOrder)
                                        <div class="list-group-item border-0 p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light rounded-4 p-2">
                                                    @if($recentOrder->items->first() && $recentOrder->items->first()->product)
                                                        <img src="{{ Storage::url($recentOrder->items->first()->product->thumbnail ?? '') }}" width="60" class="rounded-3" alt="Item">
                                                    @else
                                                        <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="bi bi-box text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Order #{{ $recentOrder->order_number }}</h6>
                                                    <p class="text-muted small mb-0">Placed on {{ $recentOrder->created_at->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($recentOrder->status == 'pending')
                                                    <a href="{{ route('payment.show', $recentOrder) }}" class="badge bg-warning text-dark px-3 py-2 rounded-pill text-decoration-none border border-warning">
                                                        Pay Now <i class="bi bi-arrow-right-short"></i>
                                                    </a>
                                                @elseif($recentOrder->status == 'processing')
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Processing</span>
                                                @elseif($recentOrder->status == 'on_delivery')
                                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">On Delivery</span>
                                                @elseif($recentOrder->status == 'delivered')
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Delivered</span>
                                                @elseif($recentOrder->status == 'cancelled')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Cancelled</span>
                                                @endif
                                                <span class="fw-bold fs-5">Rp {{ number_format($recentOrder->total_amount, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 text-center text-muted">
                                        <i class="bi bi-bag-x fs-1 mb-2 d-block"></i>
                                        No recent orders found.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="orders" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom p-4">
                                <h5 class="fw-bold mb-0">Order History</h5>
                            </div>
                            <div class="card-body p-0">
                                @forelse($orders as $order)
                                <div class="p-4 border-bottom">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="fw-bold me-2">#{{ $order->order_number }}</span>
                                            <span class="text-muted small">{{ $order->created_at->format('d M Y') }}</span>
                                        </div>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Processing</span>
                                        @elseif($order->status == 'on_delivery')
                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">On Delivery</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Delivered</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Cancelled</span>
                                        @endif
                                    </div>
                                    
                                    @foreach($order->items as $item)
                                    <div class="d-flex gap-3 align-items-center mb-3">
                                        <div class="bg-light rounded-3 overflow-hidden" style="width: 70px; height: 70px;">
                                             <img src="{{ Storage::url($item->product->thumbnail ?? '') }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $item->product->name }} (x{{ $item->quantity }})</h6>
                                            <small class="text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-light">
                                         <div class="fw-bold text-primary fs-5">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                         <div class="d-flex gap-2 justify-content-end">
                                            @if($order->payment_status === 'paid' || $order->status === 'delivered')
                                                <a href="{{ route('orders.invoice', $order) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">Invoice</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center p-5 text-muted">
                                    <i class="bi bi-box-seam display-4 mb-3 d-block opacity-50"></i>
                                    <p class="mb-0">You have no order history.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="wishlist" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom p-4">
                                <h5 class="fw-bold mb-0">My Wishlist</h5>
                            </div>
                            <div class="card-body p-4">
                                @if(isset($wishlists) && $wishlists->count() > 0)
                                    <div class="row g-4">
                                        @foreach($wishlists as $item)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card h-100 border-0 shadow-sm product-card">
                                                    <div class="position-relative overflow-hidden">
                                                        <img src="{{ Storage::url($item->product->thumbnail) }}" class="card-img-top object-fit-cover" alt="{{ $item->product->name }}" style="height: 200px;">
                                                        <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center text-danger" style="width: 32px; height: 32px;">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="card-title fw-bold text-dark mb-1">{{ $item->product->name }}</h6>
                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                            <span class="fw-bold text-primary">Rp {{ number_format($item->product->discount_price ?? $item->product->price, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div class="mt-3">
                                                            <form action="{{ route('cart.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button type="submit" class="btn btn-outline-primary w-100 rounded-pill btn-sm">Add to Cart</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-heart fs-1 text-muted opacity-25 mb-3 d-block"></i>
                                        <h4 class="fw-bold text-muted">Your wishlist is empty</h4>
                                        <a href="/collections" class="btn btn-primary rounded-pill mt-3 px-4 fw-bold">Start Shopping</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="address" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">My Addresses</h5>
                            <button class="btn btn-primary rounded-pill btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="bi bi-plus-lg me-1"></i> Add New
                            </button>
                        </div>

                        <div class="row g-4" id="address-list">
                            @forelse($addresses as $address)
                                @include('profile.partials.address-card', ['address' => $address])
                            @empty
                            <div class="col-12 text-center py-5" id="no-address-state">
                                <i class="bi bi-geo-alt fs-1 text-muted opacity-25 mb-3 d-block"></i>
                                <h4 class="fw-bold text-muted">No addresses saved yet</h4>
                            </div>
                            @endforelse
                        </div>

                        <!-- Add Address Modal -->
                        <div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Add New Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="{{ route('address.store') }}" method="POST">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="label" name="label" placeholder="e.g. Home, Office" required>
                                                <label for="label">Label (e.g. Home, Office)</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="recipient_name" name="recipient_name" placeholder="Recipient Name" required>
                                                <label for="recipient_name">Recipient Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <div class="input-group">
                                                    <select class="form-select flex-grow-0 w-auto" id="addrCountryCode" style="min-width: 100px;">
                                                        <option value="+62">ID (+62)</option>
                                                        <option value="+60">MY (+60)</option>
                                                        <option value="+65">SG (+65)</option>
                                                        <option value="+1">US (+1)</option>
                                                    </select>
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="tel" class="form-control rounded-0 rounded-end" id="addrPhoneDisplay" placeholder="8123456789" required>
                                                        <label for="addrPhoneDisplay">Phone Number</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="phone" id="addrPhoneFull">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" placeholder="Address Line" id="address_line" name="address_line" style="height: 100px" required></textarea>
                                                <label for="address_line">Address Details</label>
                                            </div>
                                            <div class="row g-2 mb-4">
                                                <div class="col-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                                        <label for="city">City</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" required>
                                                        <label for="postal_code">Postal Code</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">Save Address</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom p-4">
                                <h5 class="fw-bold mb-0">Account Details</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="d-flex align-items-center gap-4 mb-5">
                                        <div class="position-relative">
                                            <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=C89D66&color=fff' }}" 
                                                 alt="Profile" 
                                                 class="rounded-circle object-fit-cover shadow-sm" 
                                                 style="width: 100px; height: 100px;" 
                                                 id="avatarPreview">
                                            <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm border p-1 cursor-pointer" style="cursor: pointer;">
                                                <i class="bi bi-camera-fill text-muted fs-6 m-1"></i>
                                            </label>
                                            <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Profile Picture</h6>
                                            <p class="text-muted small mb-0">PNG, JPG up to 1MB</p>
                                        </div>
                                    </div>

                                    <h6 class="fw-bold mb-3">Personal Information</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="fName" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                                <label for="fName">Full Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="uEmail" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                                <label for="uEmail">Email Address</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <div class="input-group">
                                                    <select class="form-select flex-grow-0 w-auto" id="countryCode" style="min-width: 100px;">
                                                        <option value="+62">ID (+62)</option>
                                                        <option value="+60">MY (+60)</option>
                                                        <option value="+65">SG (+65)</option>
                                                        <option value="+1">US (+1)</option>
                                                    </select>
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="tel" class="form-control rounded-0 rounded-end" id="uPhoneDisplay" placeholder="8123456789">
                                                        <label for="uPhoneDisplay">Phone Number (WhatsApp Active)</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="phone" id="uPhoneFull" value="{{ old('phone', Auth::user()->phone) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="fw-bold mb-3">Password Change</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="curPass" name="current_password" placeholder="Current">
                                                <label for="curPass">Current Password (leave blank to keep)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="newPass" name="password" placeholder="New">
                                                <label for="newPass">New Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="conPass" name="password_confirmation" placeholder="Confirm">
                                                <label for="conPass">Confirm New Password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <x-footer></x-footer>

    <script>

        window.switchTab = function(tabId) {
            const triggerEl = document.querySelector(`#pills-tab button[data-bs-target="#${tabId === 'orders-tab' ? 'orders' : tabId}"]`);
            if(triggerEl) {
                const tab = bootstrap.Tab.getOrCreateInstance(triggerEl);
                tab.show();
            } else {
                const tabLink = document.querySelector(`button[id="${tabId}"]`);
                if(tabLink) {
                    const tab = bootstrap.Tab.getOrCreateInstance(tabLink);
                    tab.show();
                }
            }
        };

        window.confirmDeleteAddress = function(button) {
            Swal.fire({
                title: 'Delete Address?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = button.closest('form');
                    
                    fetch(form.action, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Address deleted successfully'
                            });
                            
                            button.closest('.address-card-col').remove();
                        }
                    });
                }
            });
        };

        document.getElementById('logout-form-account').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of your account.",
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

        document.addEventListener('DOMContentLoaded', function() {
            // Check for hash in URL to switch tabs
            if(window.location.hash) {
                const triggerEl = document.querySelector(`.list-group-item[href="${window.location.hash}"]`);
                if(triggerEl) {
                    const tab = bootstrap.Tab.getOrCreateInstance(triggerEl);
                    tab.show();
                }
            }

            // --- User Profile Phone Number Handling ---
            const countrySelect = document.getElementById('countryCode');
            const phoneDisplay = document.getElementById('uPhoneDisplay');
            const phoneFull = document.getElementById('uPhoneFull');

            if (countrySelect && phoneDisplay && phoneFull) {
                // Initial Load: Parse existing value
                let currentVal = phoneFull.value;
                if (currentVal) {
                    let matched = false;
                    Array.from(countrySelect.options).forEach(opt => {
                         if (currentVal.startsWith(opt.value)) {
                             countrySelect.value = opt.value;
                             phoneDisplay.value = currentVal.substring(opt.value.length);
                             matched = true;
                         }
                    });
                    if (!matched) {
                        phoneDisplay.value = currentVal; // Fallback
                    }
                }

                function updatePhone() {
                    phoneFull.value = countrySelect.value + phoneDisplay.value;
                }
                countrySelect.addEventListener('change', updatePhone);
                phoneDisplay.addEventListener('input', updatePhone);
            }

            // --- Address Form Phone Number Handling ---
            const addrCountrySelect = document.getElementById('addrCountryCode');
            const addrPhoneDisplay = document.getElementById('addrPhoneDisplay');
            const addrPhoneFull = document.getElementById('addrPhoneFull');

            if (addrCountrySelect && addrPhoneDisplay && addrPhoneFull) {
                // Default to +62
                addrCountrySelect.value = "+62";

                function updateAddressPhone() {
                    let code = addrCountrySelect.value;
                    let number = addrPhoneDisplay.value.replace(/^0+/, '');
                    if (number) {
                        addrPhoneFull.value = code + number;
                    } else {
                        addrPhoneFull.value = '';
                    }
                }
                addrCountrySelect.addEventListener('change', updateAddressPhone);
                addrPhoneDisplay.addEventListener('input', updateAddressPhone);
            }

            // --- AJAX Address Management ---
            const addressList = document.getElementById('address-list');
            const addAddressForm = document.querySelector('#addAddressModal form');
            
            // Add Address
            if(addAddressForm) {
                addAddressForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Update the phone hidden input before submitting
                    if (typeof updateAddressPhone === 'function') {
                         updateAddressPhone();
                    } else if (addrCountrySelect && addrPhoneDisplay && addrPhoneFull) {
                         // Manual update if function scope issue, though unlikely here
                        let code = addrCountrySelect.value;
                        let number = addrPhoneDisplay.value.replace(/^0+/, '');
                        if (number) addrPhoneFull.value = code + number;
                    }

                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Close modal
                            const modalEl = document.getElementById('addAddressModal');
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.hide();
                            
                            // Cleanup modal backdrop artifacts
                            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';

                            this.reset();
                            
                            // Remove empty state
                            const emptyState = document.getElementById('no-address-state');
                            if(emptyState) emptyState.remove();
                            
                            // Append new address
                            if(addressList) addressList.insertAdjacentHTML('beforeend', data.html);

                            // Show success toast (SweetAlert)
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Address added successfully'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please check your input.'
                        });
                    });
                });
            }

            // Delegation for Set Primary (Delete is handled via global function now)
            if(addressList) {
                addressList.addEventListener('submit', function(e) {
                    const form = e.target;
                    
                    // Set Primary
                    if(form.classList.contains('set-primary-form')) {
                         e.preventDefault();
                         fetch(form.action, {
                            method: 'PATCH',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                // 1. Reset ALL cards to non-primary state
                                document.querySelectorAll('.address-card-col .card').forEach(card => {
                                    card.classList.remove('border-primary', 'border-2');
                                    card.classList.add('border-0');
                                    
                                    const badge = card.querySelector('.primary-badge');
                                    if(badge) badge.remove();
                                    
                                    const body = card.querySelector('.card-body');
                                    body.classList.remove('pt-5');

                                    // Ensure "Set as Primary" button exists
                                    const actionDiv = body.querySelector('.d-flex.gap-2');
                                    const existingForm = actionDiv.querySelector('.set-primary-form');
                                    
                                    if(!existingForm) {
                                        const cardCol = card.closest('.address-card-col');
                                        // Start extraction from "address-card-" length
                                        const id = cardCol.id.substring(13); 
                                        
                                        const vr = document.createElement('div');
                                        vr.className = 'vr bg-secondary opacity-25 set-primary-div';
                                        
                                        const newForm = document.createElement('form');
                                        newForm.action = `/address/${id}/primary`;
                                        newForm.method = 'POST';
                                        newForm.className = 'set-primary-form';
                                        newForm.dataset.id = id;
                                        newForm.innerHTML = `
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <button type="submit" class="btn btn-sm btn-link text-primary text-decoration-none px-2 p-0 fw-bold">Set as Primary</button>
                                        `;
                                        
                                        actionDiv.appendChild(vr);
                                        actionDiv.appendChild(newForm);
                                    }
                                });

                                // 2. Set NEW Primary Styles
                                const targetCardCol = document.getElementById(`address-card-${form.dataset.id}`);
                                const targetCard = targetCardCol.querySelector('.card');
                                
                                targetCard.classList.remove('border-0');
                                targetCard.classList.add('border-primary', 'border-2');
                                
                                const badge = document.createElement('span');
                                badge.className = 'badge bg-primary bg-opacity-10 text-primary position-absolute top-0 start-0 m-3 rounded-pill px-3 primary-badge';
                                badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Primary';
                                targetCard.insertBefore(badge, targetCard.firstChild);
                                
                                const body = targetCard.querySelector('.card-body');
                                body.classList.add('pt-5');
                                
                                const actionDiv = body.querySelector('.d-flex.gap-2');
                                const setPrimaryForm = actionDiv.querySelector('.set-primary-form');
                                const vr = actionDiv.querySelector('.set-primary-div');
                                if(setPrimaryForm) setPrimaryForm.remove();
                                if(vr) vr.remove();
                            }
                        });
                    }
                });
            }
            
            // Avatar Preview
            const avatarInput = document.getElementById('avatarInput');
            if(avatarInput) {
                avatarInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('avatarPreview').src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        function markOrdersAsSeen() {
            const badge = document.getElementById('new-order-bubble');
            if (badge) {
                badge.style.display = 'none';
                
                fetch("{{ route('user.mark-orders-seen') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });
            }
        }
    </script>
    <x-sweetalert-toast />
</body>
</html>