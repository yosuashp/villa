<div class="loader text-center">
  <img src="{{ asset($activeTemplateTrue.'images/search-loading.gif') }}" alt="no image" srcset="">
</div>
  @forelse ($properties as $property)
    @if($searchData['date'] && ($property->rooms->count() <= $property->bookedRooms->count()))
      @continue
    @endif
    <div class="hotel-card">
      @if ($property->discount != 0)
      <div class="hotel-card__offer-badge">
        <b>{{ showAmount($property->discount) }}%</b> <br>
        <span>@lang('off')</span>
      </div>
      @endif

      <div class="hotel-card__thumb">
        <a href="{{ route('property', [$property->id, slug($property->name)]) }}" class="d-block"><img src="{{ getImage(imagePath()['property']['path'].'/'. $property->image, imagePath()['property']['size']) }}" alt="image"></a>
      </div>
      <div class="hotel-card__content">
        @if ($property->rating >= 4)
          <span class="fs--12px bg--primary text-white px-2 rounded-2 mb-2">@lang('Top Rated')</span>
        @endif
        @if ($property->top_reviewed)
          <span class="fs--12px bg--success text-white px-2 rounded-2 mb-2">@lang('Best Reviewed')</span>
        @endif
        <h3 class="title"><a href="{{ route('property', [$property->id, slug($property->name)]) }}">{{ __($property->name) }}</a></h3>
        <p class="mt-1"><i class="las la-map-marker-alt fs--18px"></i> {{ __($property->location->name) }}</p>
        <ul class="features-list mt-2">
          @if($property->extra_features)
            @foreach($property->extra_features as $feature)
                <li>{{ __($feature) }}</li>
                @php if($loop->iteration == 2){ break; } @endphp
            @endforeach
          @endif
        </ul>
        <div class="hotel-rating fs--14px mt-3">
          <span class="amount bg--success fs--16px px-2 text-white rounded-2">{{ showAmount($property->rating) }}</span>
          <span>{{ $property->review }} @lang('reviews')</span>
        </div>
      </div>
      <div class="hotel-card__action">
        <div class="bottom w-100">
          <div class="price text--base">
            @php
              $lowestPrice = @$property->rooms->where('status',1)->first()->price ?? 0;
              foreach ($property->rooms as $room) {
                if($room->price < $lowestPrice){
                  $lowestPrice = $room->price;
                }
              }

              $highestPrice = @$property->rooms->where('status',1)->first()->price ?? 0;
              foreach ($property->rooms as $room) {
                if($room->price > $highestPrice){
                  $highestPrice = $room->price;
                }
              }
          @endphp

        <span class="{{ $highestPrice > 9999 ? 'd-block' : '' }}">{{ $general->cur_sym.showAmount($lowestPrice) }}</span>
        -
        <span class="{{ $highestPrice > 9999 ? 'd-block' : '' }}">{{ $general->cur_sym.showAmount($highestPrice) }}</span>
          </div>
          <p class="fs--14px">@lang('price per night')</p>
          <a href="{{ route('property', [$property->id, slug($property->name)]) }}" class="btn btn-sm btn--base mt-3 w-100">@lang('View Details')</a>
        </div>
      </div>
    </div><!-- hotel-card end -->
  @empty
      <div class="text-center">
      {{ $emptyMessage }}
      </div>
  @endforelse
<div class="text-end mt-4 pagination-md">
  <ul class="pagination d-inline-flex">
    {{ $properties->links() }}
  </ul>
</div>
