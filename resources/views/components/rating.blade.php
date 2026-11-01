@props(['value'])

<span {{ $attributes->merge(['class' => 'rating']) }} role="img"
    aria-label="{{ number_format($value, 1, ',', '.') }} dari 5 bintang">
    @for ($star = 1; $star <= 5; $star++)
        <i class="{{ $value >= $star ? 'fas fa-star' : ($value >= $star - 0.5 ? 'fas fa-star-half-stroke' : 'far fa-star') }}"
            aria-hidden="true"></i>
    @endfor
</span>
