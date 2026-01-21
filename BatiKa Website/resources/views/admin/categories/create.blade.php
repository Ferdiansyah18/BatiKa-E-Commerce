<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold mb-0 text-dark">
            {{ __('Add New Category') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
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

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control form-control-lg" placeholder="e.g. Handmade Bags" required>
                        </div>

                        <div class="mb-5">
                            <label for="icon" class="form-label fw-semibold">Icon Class (Bootstrap Icons)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-bootstrap"></i></span>
                                <input type="text" name="icon" id="icon" value="{{ old('icon') }}" class="form-control" placeholder="e.g. bi-bag-fill">
                            </div>
                            <div class="form-text text-muted">
                                Use icons from <a href="https://icons.getbootstrap.com/" target="_blank" class="text-primary text-decoration-none">Bootstrap Icons</a>.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-lg">
                                Save Category
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>