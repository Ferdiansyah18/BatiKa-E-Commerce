<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'payment_method' => 'required|string',
            'full_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = auth()->user();
        $checkoutItemIds = session('checkout_item_ids', []);

        if (empty($checkoutItemIds)) {
            return redirect()->route('cart.index')->with('error', 'No items to checkout.');
        }

        $cartItems = Cart::with('product')
            ->whereIn('id', $checkoutItemIds)
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
             return redirect()->route('cart.index')->with('error', 'Cart items not found.');
        }

        $totalAmount = $cartItems->sum(function($item) {
             return $item->quantity * ($item->product->discount_price ?? $item->product->price);
        });
        
        // Construct Shipping Address from Request Data
        $shippingAddress = [
            'name' => $request->full_name,
            'phone' => $user->phone, // Or add phone to the form if needed, for now usage user phone
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'email' => $request->email,
        ];

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'shipping_address' => $shippingAddress, // Will be cast to JSON
            ]);

            // Config Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $shippingAddress['phone'] ?? $user->phone,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                ]);
            }

            // Remove items from cart
            Cart::whereIn('id', $checkoutItemIds)->delete();
            
            // Clear checkout session
            session()->forget('checkout_item_ids');

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'order_id' => $order->id,
                    'snap_token' => $order->snap_token,
                    'redirect_url' => route('payment.success', ['order' => $order])
                ]);
            }

            return redirect()->route('payment.show', ['order' => $order]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process order. ' . $e->getMessage());
        }
    }
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'admin'])) {
            abort(403);
        }
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'admin'])) {
            abort(403);
        }
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'admin'])) {
            abort(403);
        }
        $validated = $request->validate([
            'status' => 'required|in:processing,on_delivery,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }
    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status !== 'paid') {
            return redirect()->route('account.dashboard')->with('error', 'Invoice is only available for paid orders.');
        }

        $order->load(['items.product', 'user']);
        return view('orders.invoice', compact('order'));
    }
}
