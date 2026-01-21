<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold mb-0 text-dark">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Add New Product
            </a>
        </div>
    </x-slot>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-0 mb-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase ls-1">
                            <th class="py-3 px-4 border-bottom-0">Thumbnail</th>
                            <th class="py-3 px-4 border-bottom-0">Name & Slug</th>
                            <th class="py-3 px-4 border-bottom-0">Category</th>
                            <th class="py-3 px-4 border-bottom-0">Price</th>
                            <th class="py-3 px-4 border-bottom-0">Discount</th>
                            <th class="py-3 px-4 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <img src="{{ Storage::url($product->thumbnail) }}" alt="" class="rounded-3 object-fit-cover border" width="50" height="50">
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                <div class="small text-muted mb-1">ID: #{{ $product->id }}</div>
                                <div class="badge bg-light text-secondary border fw-normal">{{ $product->slug }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                            </td>
                            <td class="px-4 py-3 fw-bold">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($product->discount_price)
                                    <div><span class="text-danger fw-bold">${{ number_format($product->discount_price, 2) }}</span></div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        Until {{ $product->discount_end_date ? $product->discount_end_date->format('M d') : 'Forever' }}
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-trash-fill" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-4 py-3 border-top d-flex justify-content-center align-items-center">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>