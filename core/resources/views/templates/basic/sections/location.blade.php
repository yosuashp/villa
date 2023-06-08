@php
$location = getContent('location.content', true);
$locations = \App\Models\Location::where('status', 1)->orderBy('id', 'DESC')->limit(10)->get();
@endphp
<!-- location section start -->
<section class="pt-100 pb-100 bg_img location-section" style="background-image: url('{{ getImage('assets/images/frontend/location/'.$location->data_values->background_image, '1920x1280') }}');">
    <div class="container-fluid">
      <div class="row justify-content-xl-end justify-content-center">
        <div class="col-xl-3 col-lg-6 col-md-8 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
          <div class="section-header text-xl-start text-center">
            <h2 class="section-title">{{ __($location->data_values->heading) }}</h2>
            <p class="mt-3">{{ __($location->data_values->sub_heading) }}</p>
            <a href="{{ $location->data_values->button_url }}" class="btn btn--base mt-4">{{ __($location->data_values->button) }}</a>
          </div>
        </div>
        <div class="col-xxl-7 col-xl-9 ps-4">
          <div class="location-slider">
            @foreach ($locations as $location)
            @if ($location->image)
            <div class="single-slide">
              <div class="location-card has--link rounded-3">
                <a href="{{ route('search.location.property', [$location->id, slug($location->name)]) }}" class="item--link"></a>
                <img src="{{getImage(imagePath()['location']['path'].'/'. $location->image,imagePath()['location']['size'])}}" alt="image">
                <div class="overlay-content">
                  <div class="top">
                  </div>
                  <div class="bottom">
                    <h4 class="location-name text-white">{{ __($location->name) }}</h4>
                    <p class="text-white fs--14px">@lang('Average price') <span class="float-end">{{ $general->cur_sym }}{{ showAmount($location->average_price) }}</span></p>
                  </div>
                </div>
              </div><!-- location-card end -->
            </div><!-- single-slide end -->
            @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- location section end -->
