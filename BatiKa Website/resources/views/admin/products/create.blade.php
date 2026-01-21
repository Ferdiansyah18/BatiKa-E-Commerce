<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold mb-0 text-dark">
            {{ __('Add New Product') }}
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

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Basic Information</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Product Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Elegant Batik Tote" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="category_id" class="form-label fw-semibold">Category</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
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
                                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_price" class="form-label fw-semibold">Discount Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">$</span>
                                        <input type="number" step="0.01" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" class="form-control">
                                    </div>
                                    <small class="text-muted">Optional. Must be lower than price.</small>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_start_date" class="form-label fw-semibold">Discount Start</label>
                                    <input type="datetime-local" name="discount_start_date" id="discount_start_date" value="{{ old('discount_start_date') }}" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="discount_end_date" class="form-label fw-semibold">Discount End</label>
                                    <input type="datetime-local" name="discount_end_date" id="discount_end_date" value="{{ old('discount_end_date') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Specs -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Specifications</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="material" class="form-label fw-semibold">Material</label>
                                    <input type="text" name="material" id="material" value="{{ old('material') }}" class="form-control" placeholder="e.g. Genuine Cowhide & Cotton">
                                </div>
                                <div class="col-md-6">
                                    <label for="dimensions" class="form-label fw-semibold">Dimensions</label>
                                    <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions') }}" class="form-control" placeholder="e.g. 30cm x 25cm x 12cm">
                                </div>
                                <div class="col-md-6">
                                    <label for="strap_drop" class="form-label fw-semibold">Strap Drop</label>
                                    <input type="text" name="strap_drop" id="strap_drop" value="{{ old('strap_drop') }}" class="form-control" placeholder="e.g. 25cm (Adjustable)">
                                </div>
                                <div class="col-md-6">
                                    <label for="weight" class="form-label fw-semibold">Weight</label>
                                    <input type="text" name="weight" id="weight" value="{{ old('weight') }}" class="form-control" placeholder="e.g. 0.8 kg">
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Description</h5>
                            <div>
                                <label for="description" class="form-label fw-semibold">Product Description</label>
                                <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
                                <small class="text-muted">Tell the story of the batik pattern and craftsmanship.</small>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom">Product Images</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="thumbnail" class="form-label fw-semibold">Main Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                                    <small class="text-muted">This image will appear on the product card.</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="images" class="form-label fw-semibold">Gallery Images</label>
                                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                                    <small class="text-muted">Upload multiple images for the product detail page carousel.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-lg">
                                Save Product
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>