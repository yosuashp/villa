@foreach ($reviews as $review)
    <div class="mb-3 py-3 border-bottom">
        <ul class="as-rating-list mt-0">
            @for($i=0; $i<$review->rating; $i++)
                <li class="as-rating-list__item">
                    <span class="as-rating-icon as-rating-icon--sm">
                        <i class="fas fa-star"></i>
                    </span>
                </li>
            @endfor
        </ul>
        <small class="text-muted mb-3">@lang('By ') {{ __($review->user->fullname) }}</small>
        <p class="sm-text">
            {{ __($review->description) }}
        </p>
    </div>
@endforeach