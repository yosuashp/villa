<div class="tab-pane fade show active" id="hotel-description">
    <div class="hotel-details-box pt-4">
        @if ($property->rating >= 4)
            <span class="fs--12px bg--primary text-white px-2 rounded-2 mb-2">@lang('Top
                Rated')</span>
        @endif
        @if ($property->top_reviewed)
            <span class="fs--12px bg--success text-white px-2 rounded-2 mb-2">@lang('Best
                Reviewed')</span>
        @endif
        <h2 class="hotel-name">{{ __($property->name) }}</h2>
        <p class="mt-1"><i class="las la-map-marker-alt fs--18px"></i>
            {{ __($property->location->name) }}</p>
        <ul class="features-list mt-2">
            @foreach ($property->extra_features as $feature)
                <li>{{ __($feature) }}</li>
            @endforeach
        </ul>
    </div><!-- hotel-details-box end -->
    <div class="hotel-details-box">
        @php
            echo $property->description;
        @endphp
    </div><!-- hotel-details-box end -->
</div>