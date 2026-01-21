<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->discount_price ?? $item->product->price);
        });

        return view('pages.cart', compact('cartItems', 'subtotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ensure user owns this cart item
        if ($cart->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Ensure user owns this cart item
        if ($cart->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Update quantities and proceed to checkout.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        // Update quantities first
        foreach ($request->quantities as $cartId => $quantity) {
            $cart = Cart::where('id', $cartId)->where('user_id', auth()->id())->first();
            if ($cart) {
                $cart->update(['quantity' => $quantity]);
            }
        }

        // Store selected items in session for payment page
        session(['checkout_item_ids' => $request->selected_items]);

        return redirect('/payment');
    }
}
