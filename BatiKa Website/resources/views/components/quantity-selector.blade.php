@props([
    'name' => 'quantity',
    'min' => 1,
    'max' => 20,
    'value' => 1,
])

<div class="quantity-selector qty-compact" data-min="{{ $min }}" data-max="{{ $max }}">
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary btn-decrease">-</button>

        <input
            type="number"
            class="form-control text-center qty-input"
            name="{{ $name }}"
            value="{{ $value }}"
            min="{{ $min }}"
            max="{{ $max }}"
            step="1"
            inputmode="numeric"
        >

        <button type="button" class="btn btn-outline-secondary btn-increase">+</button>
    </div>
</div>
