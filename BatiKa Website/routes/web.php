<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('is_featured', true)
        ->latest()
        ->take(3)
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->get();
    return view('home', compact('featuredProducts'));
})->name('home');

Route::get('/product/{product:slug}', [\App\Http\Controllers\ShopController::class, 'show'])
    ->name('product.detail');

Route::get('/collections', function() {
    return view('pages.collections');
});

Route::get('/payment', function() {
    $checkoutItemIds = session('checkout_item_ids', []);
    
    if (empty($checkoutItemIds)) {
        return redirect()->route('cart.index')->with('error', 'Please select items to checkout.');
    }

    $checkoutItems = \App\Models\Cart::with('product')
        ->whereIn('id', $checkoutItemIds)
        ->where('user_id', auth()->id())
        ->get();

    if ($checkoutItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Selected items not found.');
    }

    $subtotal = $checkoutItems->sum(function($item) {
        return $item->quantity * ($item->product->discount_price ?? $item->product->price);
    });

    $primaryAddress = auth()->user()->addresses()->where('is_primary', true)->first();

    return view('pages.payment', compact('checkoutItems', 'subtotal', 'primaryAddress'));
});

Route::middleware('auth')->group(function () {
    Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
    
    Route::get('/payment/{order}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');

    Route::get('/payment-info/{order}', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
});

Route::post('/midtrans/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('midtrans.callback');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::patch('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    // Address Routes
    Route::post('/address', [\App\Http\Controllers\AddressController::class, 'store'])->name('address.store');
    Route::delete('/address/{address}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('address.destroy');
    Route::patch('/address/{address}/primary', [\App\Http\Controllers\AddressController::class, 'setPrimary'])->name('address.primary');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', function() {
        if (auth()->user()->hasAnyRole(['owner', 'admin'])) {
            return redirect()->route('dashboard');
        }
        $wishlists = \App\Models\Wishlist::with('product')->where('user_id', auth()->id())->get();
        $addresses = auth()->user()->addresses; 
        $orders = \App\Models\Order::with('items.product')->where('user_id', auth()->id())->latest()->get();
        $orders = \App\Models\Order::with('items.product')->where('user_id', auth()->id())->latest()->get();
        $inProgressCount = $orders->whereIn('status', ['pending', 'processing', 'on_delivery'])->count();
        $completedCount = $orders->where('status', 'delivered')->count();
        
        // Find the most recent 3 orders
        $dashboardRecentOrders = $orders->take(3);

        
        $lastViewed = auth()->user()->last_viewed_orders_at;
        $unseenOrdersCount = $orders->filter(function ($order) use ($lastViewed) {
             return $lastViewed ? $order->created_at > $lastViewed : true;
        })->count();

        return view('profile.dashboard-user', compact('wishlists', 'addresses', 'orders', 'inProgressCount', 'completedCount', 'dashboardRecentOrders', 'unseenOrdersCount'));
    })->name('account.dashboard');

    Route::post('/user/mark-orders-seen', function() {
        auth()->user()->update(['last_viewed_orders_at' => now()]);
        return response()->json(['success' => true]);
    })->name('user.mark-orders-seen');
});

Route::get('/about-us', function() {
    return view('pages.about-us');
});

Route::get('/contact-us', function() {
    return view('pages.contact-us');
});

Route::get('/shipping-policy', function() {
    return view('pages.policy');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Tracking
    // Route::get('/tracking/{order:order_number}', [TrackingController::class, 'show'])->name('tracking.show');
    
    // Reviews
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});
    Route::prefix('admin')->name('admin.')->middleware(['role:admin|owner'])->group(function(){
        Route::resource('products', ProductController::class);
        Route::resource('categories',CategoryController::class);
        Route::resource('orders', \App\Http\Controllers\OrderController::class);
    });


// OTP Verification Routes
Route::get('/verify-otp', [\App\Http\Controllers\Auth\OtpVerificationController::class, 'show'])->name('otp.notice');
Route::post('/verify-otp', [\App\Http\Controllers\Auth\OtpVerificationController::class, 'verify'])->name('otp.verify');
Route::post('/verify-otp/resend', [\App\Http\Controllers\Auth\OtpVerificationController::class, 'resend'])->name('otp.resend');

require __DIR__.'/auth.php';
