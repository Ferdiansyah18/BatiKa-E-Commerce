<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'material' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'strap_drop' => 'nullable|string',
            'weight' => 'nullable|string',
            'discount_price' => 'nullable|numeric|lt:price',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date|after:discount_start_date',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $data['specifications'] = [
            'material' => $request->material,
            'dimensions' => $request->dimensions,
            'strap_drop' => $request->strap_drop,
            'weight' => $request->weight,
        ];

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'discount_price' => 'nullable|numeric|lt:price',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date|after:discount_start_date',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $data['specifications'] = [
            'material' => $request->material,
            'dimensions' => $request->dimensions,
            'strap_drop' => $request->strap_drop,
            'weight' => $request->weight,
        ];

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
