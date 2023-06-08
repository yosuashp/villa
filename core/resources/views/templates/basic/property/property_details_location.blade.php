<div class="tab-pane fade" id="hotel-location">
    @if ($property->map_url)
        <div class="hotel-details-box pt-4">
            <h3 class="title mb-4">@lang('Location')</h3>
            <div class="hotel-details-map">
                <iframe src="{{ $property->map_url }}" allowfullscreen=""
                    loading="lazy"></iframe>
            </div>
        </div><!-- hotel-details-box end -->
    @endif
</div>