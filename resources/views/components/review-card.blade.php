@props(['review', 'showService' => true])

<figure class="review-card h-100 mb-0">
    <x-rating :value="$review->rating" />
    <blockquote class="review-comment">{{ $review->comment }}</blockquote>
    <figcaption class="review-author">
        <strong>{{ $review->reviewer_name }}</strong>
        @if ($showService)
            <span>{{ $review->order->service->name }}</span>
        @endif
    </figcaption>
</figure>
