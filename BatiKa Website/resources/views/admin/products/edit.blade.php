<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold mb-0 text-dark">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-body p-4 p-lg-5">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Basic Information</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Product Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="category_id" class="form-label fw-semibold">Category</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="is_featured">Set as Featured Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Pricing & Discount</h5>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-3">
                                    <label for="price" class="form-label fw-semibold">Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">$</span>
                                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_price" class="form-label fw-semibold">Discount Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">$</span>
                                        <input type="number" step="0.01" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_start_date" class="form-label fw-semibold">Discount Start</label>
                                    <input type="datetime-local" name="discount_start_date" id="discount_start_date" value="{{ old('discount_start_date', $product->discount_start_date ? $product->discount_start_date->format('Y-m-d\TH:i') : '') }}" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_end_date" class="form-label fw-semibold">Discount End</label>
                                    <input type="datetime-local" name="discount_end_date" id="discount_end_date" value="{{ old('discount_end_date', $product->discount_end_date ? $product->discount_end_date->format('Y-m-d\TH:i') : '') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Specs -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Specifications</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="material" class="form-label fw-semibold">Material</label>
                                    <input type="text" name="material" id="material" value="{{ old('material', $product->specifications['material'] ?? '') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="dimensions" class="form-label fw-semibold">Dimensions</label>
                                    <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $product->specifications['dimensions'] ?? '') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="strap_drop" class="form-label fw-semibold">Strap Drop</label>
                                    <input type="text" name="strap_drop" id="strap_drop" value="{{ old('strap_drop', $product->specifications['strap_drop'] ?? '') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="weight" class="form-label fw-semibold">Weight</label>
                                    <input type="text" name="weight" id="weight" value="{{ old('weight', $product->specifications['weight'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Description</h5>
                            <div>
                                <label for="description" class="form-label fw-semibold">Product Description</label>
                                <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Product Images</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="thumbnail" class="form-label fw-semibold">Main Thumbnail</label>
                                    <div class="mb-3 p-3 bg-light rounded-3 text-center">
                                        <img src="{{ Storage::url($product->thumbnail) }}" alt="Current Thumbnail" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                        <p class="text-muted small mt-2 mb-0">Current Thumbnail</p>
                                    </div>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                                    <small class="text-muted">Leave empty to keep current thumbnail</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="images" class="form-label fw-semibold">Gallery Images</label>
                                    <div class="mb-3 d-flex gap-2 bg-light p-3 rounded-3 overflow-auto">
                                        @forelse($product->images as $img)
                                             <img src="{{ Storage::url($img->image_path) }}" class="rounded border bg-white" style="height: 80px; width: 80px; object-fit: cover;">
                                        @empty
                                            <span class="text-muted small">No gallery images yet.</span>
                                        @endforelse
                                    </div>
                                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                                    <small class="text-muted">Add more images to the gallery</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-lg">
                                Update Product
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>