<div class="col-md-6 address-card-col" id="address-card-{{ $address->id }}">
    <div class="card shadow-sm rounded-4 h-100 position-relative {{ $address->is_primary ? 'border-primary border-2' : 'border-0' }}">
        @if($address->label == 'Home')
            <span class="badge bg-primary position-absolute top-0 end-0 m-3 rounded-pill">{{ $address->label }}</span>
        @else
            <span class="badge bg-secondary position-absolute top-0 end-0 m-3 rounded-pill">{{ $address->label }}</span>
        @endif
        
        @if($address->is_primary)
             <span class="badge bg-primary bg-opacity-10 text-primary position-absolute top-0 start-0 m-3 rounded-pill px-3 primary-badge"><i class="bi bi-check-circle-fill me-1"></i> Primary</span>
        @endif

        <div class="card-body p-4 {{ $address->is_primary ? 'pt-5' : '' }}">
            <h6 class="fw-bold mb-1">{{ $address->recipient_name }}</h6>
            <p class="text-muted small mb-3">{{ $address->phone }}</p>
            <p class="text-dark small mb-4">
                {{ $address->address_line }}<br>
                {{ $address->city }}, {{ $address->postal_code }}
            </p>
            <div class="d-flex gap-2 align-items-center">
                <form action="{{ route('address.destroy', $address->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none px-2 p-0" onclick="confirmDeleteAddress(this)">Delete</button>
                </form>
                
                @if(!$address->is_primary)
                <div class="vr bg-secondary opacity-25 set-primary-div"></div>
                <form action="{{ route('address.primary', $address->id) }}" method="POST" class="set-primary-form" data-id="{{ $address->id }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-link text-primary text-decoration-none px-2 p-0 fw-bold">Set as Primary</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
