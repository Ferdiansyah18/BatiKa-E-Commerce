<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Review;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // Filter by Category
        $query->when($request->filled('categories'), function ($q) use ($request) {
            $categories = (array) $request->categories;
            $q->whereIn('category_id', $categories);
        });

        // Filter by Price
        $query->when($request->filled('min_price'), function ($q) use ($request) {
             $q->where('price', '>=', $request->min_price);
        });
        
        $query->when($request->filled('max_price'), function ($q) use ($request) {
             $q->where('price', '<=', $request->max_price);
        });

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default: // newest
                $query->latest();
                break;
        }

        $products = $query->paginate(9)->withQueryString();
        
        $categories = \App\Models\Category::withCount('products')->get();

        return view('pages.collections', compact('products', 'categories'));
    }

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
    public function showCollection(\App\Models\Category $category)
    {
        $products = $category->products()
            ->with(['reviews', 'category'])
            ->withAvg('reviews', 'rating')
            ->count('reviews');
            
        // Get all other categories for "Explore More" section if needed, 
        // or just pass products. We will stick to the plan.
        
        $products = $category->products()
             ->withAvg('reviews', 'rating')
             ->withCount('reviews')
             ->paginate(12);

        return view('pages.collection-story', compact('category', 'products'));
    }
}
