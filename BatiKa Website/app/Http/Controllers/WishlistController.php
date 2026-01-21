<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')->where('user_id', auth()->id())->get();
        return view('pages.wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product is already in your wishlist.']);
            }
            return redirect()->back()->with('error', 'Product is already in your wishlist.');
        }

        $wishlist = Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Product added to wishlist!',
                'id' => $wishlist->id 
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }
            abort(403);
        }

        $wishlist->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product removed from wishlist.']);
        }

        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }
}
