<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|max:1000',
            'image'      => 'nullable|image|max:2048', // 2MB max
        ]);

        $user = auth()->user();
        $productId = $request->product_id;

        // 1. Verify Purchase (Must be in a paid order)
        $hasPurchased = Order::where('user_id', $user->id)
            ->whereIn('status', ['processing', 'on_delivery', 'delivered'])
            ->where('payment_status', 'paid')
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
             return redirect()->back()->with('error', 'You can only review products you have purchased and received.');
        }

        // 2. Check for Duplicate Review
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        // 3. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        // 4. Store Review
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_path' => $imagePath,
            'is_verified_purchase' => true
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
