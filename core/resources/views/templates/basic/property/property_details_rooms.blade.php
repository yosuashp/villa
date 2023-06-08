<div class="tab-pane fade" id="hotel-category">
    <div class="hotel-details-box pt-4">
        <div class="aminities-grid">
            @foreach ($property->roomCategories as $roomCategory)
                <div class="aminities-item">
                    <h5 class="h--font fw-medium text-white">
                        {{ __($roomCategory->name) }}</h5>
                    <ul class="aminities-list">
                        @foreach ($roomCategory->amenities as $amenity)
                            @if ($loop->index == 5)
                                <li class="text-white">@lang("And More")</li>
                            @break
                            @endif
                            <li class="text-white">{{ __($amenity->name) }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('property.category.rooms', [$property->id, slug($property->name), $roomCategory->id]) }}" class="btn btn-sm btn--danger mt-4">@lang('Room Details')</a>
                </div>
            @endforeach
        </div>
    </div><!-- hotel-details-box end -->
</div>