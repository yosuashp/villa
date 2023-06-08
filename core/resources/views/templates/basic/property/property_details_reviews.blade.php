<div class="tab-pane fade" id="hotel-review">
    <div class="hotel-details-box border-bottom-0 py-4">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-end">
                    <span class="d-inline-block as-rating">{{ showAmount($rating = $property->rating) }}</span>
                    <span class="d-inline-block as-rating-divider">/</span>
                    <span class="d-inline-block as-rating-total">@lang('5')</span>
                </div>
                <ul class="as-rating-list">
                   @php
                       echo ratingStar($rating)
                   @endphp
                </ul>
                <span class="d-inline-block as-rating-text">{{ __($property->review) }} @lang('Ratings')</span>
            </div>
            <div class="col-md-6">
                <ul class="as-ratings">
                @for ($i = 1; $i <= 5; $i++)
                <li class="as-ratings__item">
                    <ul class="as-rating-list mt-0">
                        @for($j = 5; $j >= 1; $j--)
                            <li class="as-rating-list__item">
                                <span class="as-rating-icon as-rating-icon--sm @if($i > $j) as-rating-icon--disable @endif">
                                    <i class="fas fa-star"></i>
                                </span>
                            </li>
                        @endfor
                    </ul>
                    <div class="d-flex align-items-center">
                        <div class="progress rounded-0 flex-shrink-0 flex-grow-1 me-2" style="height: 10px;">
                            <div class="progress-bar bg--warning" role="progressbar" style="width: {{ $property->review > 0 ? $reviewCount[6-$i] / ($reviewCount[6-$i] + $property->reviews->where('rating','!=', 6-$i)->count()) * 100 : 0  }}%;"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="d-inline-block as-rating-text mt-0">{{ __($reviewCount[6-$i]) }}</span>
                    </div>
                </li>
                @endfor
                </ul>
            </div>
        </div>
    </div><!-- hotel-details-box end -->
    <div class="py-2 border-bottom border-top">
        <small>@lang('Hotel Review')</small>
    </div>
    <div class="review">
        @foreach ($property->reviews->sortByDesc('id')->take(10) as $review)
            <div class="mb-3 py-3 border-bottom">
                <ul class="as-rating-list mt-0 user-rating">
                    @php
                        echo ratingStar($review->rating)
                    @endphp
                </ul>
                <small class="text-muted mb-3">@lang('By ') {{ __($review->user->fullname) }}</small>
                <p class="sm-text">
                    {{ __($review->description) }}
                </p>
            </div>
        @endforeach
    </div>
    @if ($property->reviews->count() > 10)
        <div class="text-center">
            <button class="btn btn--base w-100 see-more">@lang('See More')</button>
        </div>
    @endif
</div>

@push('style')
    <style>
        .user-rating span{
            font-size: 14px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            let page = 10;
            let propertyId = `{{ $property->id }}`;

            $('.see-more').on('click', function(){
                var url = `{{ route('property.review.load') }}`;
                var data = { '_token': '{{ csrf_token() }}', 'page': page, 'propertyId': propertyId};
                page += 10;
                $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    $('.review').append(response);
                console.log(response);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }

                });
            })

        })(jQuery);

    </script>
@endpush