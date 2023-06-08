@php
$trip = getContent('top_trip.content', true);
$properties = \App\Models\Property::with('location', 'rooms')
  ->whereHas('rooms', function($room){
    $room->where('status', 1);
  })
  ->orderBy('all_time_booked_counter', 'DESC')->limit(5)->get();
@endphp
<!-- best trip section start -->
<section class="pt-100 pb-100 bg_img best-trip-section" style="background-image: url('{{ getImage('assets/images/frontend/top_trip/'.$trip->data_values->background_image, '1920x1090') }}');">
  <div class="container-fluid">
    <div class="row justify-content-end">
      <div class="col-xxl-6 col-xl-7 pe-xl-5">
        <div class="section-header text-xl-start text-center">
          <h2 class="section-title">{{ __($trip->data_values->heading) }}</h2>
          <p class="mt-2">{{ __($trip->data_values->sub_heading) }}</p>
        </div>
        <div class="best-trip-slider">
          @foreach ($properties as $property)
          <div class="single-slide">
            <div class="best-trip-card">
              @if ($property->discount != 0)
              <div class="best-trip-card__badge">
                <b>{{ showAmount($property->discount) }}%</b> <br>
                <span>@lang('off')</span>
              </div>
              @endif
              <div class="thumb">
                <img src="{{ getImage(imagePath()['property']['path'].'/'. $property->image, imagePath()['property']['size']) }}" alt="image">
              </div>
              <div class="content">
                <div class="top">
                  <div class="ratings">
                    @for ($i = 0; $i < round($property->rating); $i++)
                    <i class="las la-star"></i>
                    @endfor
                      <span class="fs--14px">({{ $property->review }})</span>
                  </div>
                  <h4 class="name">{{ __($property->name) }}</h4>
                  <span class="fs--14px mt-2"><i class="las la-map-marked-alt fs--18px"></i> @lang('in') {{ __($property->location->name) }}</span>
                </div>
                <div class="bottom d-flex align-items-center">
                  <div class="col-6">
                    <div class="price text--base">
                      @php
                        $lowestPrice = $property->rooms[0]->price;
                          foreach ($property->rooms as $room) {
                            if($room->price < $lowestPrice){
                              $lowestPrice = $room->price;
                            }
                          }
                          echo $general->cur_sym.showAmount($lowestPrice);
                      @endphp
                    </div>
                    <span class="fs--14px">@lang('Per night')</span>
                  </div>
                  <div class="col-6 text-end">
                    <a href="{{ route('property', [$property->id, slug($property->name)]) }}" class="btn btn-sm btn--base">@lang('View Details')</a>
                  </div>
                </div>
              </div>
            </div><!-- best-trip-card end -->
          </div><!-- single-slide end -->
          @endforeach

        </div>
      </div>
    </div>
  </div>
</section>
<!-- best trip section end -->
