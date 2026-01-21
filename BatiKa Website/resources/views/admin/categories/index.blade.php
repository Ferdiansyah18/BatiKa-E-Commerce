<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold mb-0 text-dark">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Add New Category
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
                            <th class="py-3 px-4 border-bottom-0">Icon</th>
                            <th class="py-3 px-4 border-bottom-0">Name</th>
                            <th class="py-3 px-4 border-bottom-0">Slug</th>
                            <th class="py-3 px-4 border-bottom-0">Products Count</th>
                            <th class="py-3 px-4 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 40px; height: 40px;">
                                    <i class="bi {{ $category->icon }} fs-5"></i>
                                </div>
                            </td>
                            <td class="px-4 py-3 fw-bold text-dark">
                                {{ $category->name }}
                            </td>
                            <td class="px-4 py-3 text-muted">
                                {{ $category->slug }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border">{{ $category->products->count() }} Products</span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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

        </div>
    </div>
</x-app-layout>