<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Review;

class ShopController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['reviews.user', 'category'])
            ->loadCount('reviews')
            ->loadAvg('reviews', 'rating');
        
        $canReview = false;
        
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if purchased (paid)
            $hasPurchased = Order::where('user_id', $user->id)
                ->whereIn('status', ['processing', 'on_delivery', 'delivered'])
                ->where('payment_status', 'paid')
                ->whereHas('items', function($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->exists();
                
            // Check if already reviewed
            $alreadyReviewed = Review::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->exists();
                
            $canReview = $hasPurchased && !$alreadyReviewed;
        }

        return view('pages.product-detail', compact('product', 'canReview'));
    }
}
