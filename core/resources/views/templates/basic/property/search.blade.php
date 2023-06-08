@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $banners = getContent('search_page_banner.element');
@endphp
  <!-- search result section start -->
  <div class="pb-50">
      <div class="search-area py-4 section--bg">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <form class="hotel-search-form">
                <div class="row gy-3 align-items-end">
                  <div class="col-xl-3 col-md-6">
                    <label>@lang('Location')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="las la-map-marker"></i></span>
                      <select class="select2-basic" name="location" id="location">
                        <option value="">@lang('Select One')</option>
                        @foreach ($locations as $location)
                          <option value="{{ $location->id }}" {{ $request->location == $location->id ? 'selected' : '' }}>{{ __($location->name) }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                    <label>@lang('Checkin - Checkout')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="las la-calendar-check"></i></span>
                      <input type="text" name="date" value="{{ $request->date }}" id="date" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form--control" placeholder="M/D/Y - M/D/Y" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-xl-2 col-sm-6">
                    <label>@lang('Adult')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="las la-user"></i></span>
                      <input type="number" name="adult" id="adult" autocomplete="off" value="{{ $request->adult }}" min="1" class="form--control">
                    </div>
                  </div>
                  <div class="col-xl-2 col-sm-6">
                    <label>@lang('Child')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="las la-child"></i></span>
                      <input type="number" name="child" id="child" autocomplete="off" value="{{ $request->child }}" min="0" class="form--control">
                    </div>
                  </div>
                  <div class="col-xl-2 text-end">
                    <button type="submit" class="btn btn--base w-100">@lang('Search')</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="pt-50">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 pe-5">
              <button class="action-sidebar-open"><i class="las la-sliders-h"></i> @lang('Filter')</button>
              <div class="action-sidebar">
                <button class="action-sidebar-close"><i class="las la-times"></i></button>
                <div class="action-widget">
                  <h4 class="action-widget__title">@lang('Property Types')</h4>
                  <div class="action-widget__body">
                    <select class="select select-sm propertyType">
                      <option value="">@lang('Select type')</option>
                      @foreach ($propertyTypes as $propertyType)
                      <option value="{{ $propertyType->id }}" {{ $request->propertyType == $propertyType->id ? 'selected':'' }}>{{ __($propertyType->name) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- action-widget end -->
                <div class="action-widget">
                  <h6 class="action-widget__title">@lang('Filter by price')</h6>
                  <div class="action-widget__body">
                    <div class="row">
                      <div class="col-6">
                        <input type="number" placeholder="min" min="0" step="any" class="form--control form-control-sm min_price">
                      </div>
                      <div class="col-6">
                        <input type="number" placeholder="max" min="0" step="any" class="form--control form-control-sm max_price">
                      </div>
                      <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-sm btn--base w-100" id="filter_btn">@lang('Filter')</button>
                      </div>
                    </div>
                  </div>
                </div><!-- action-widget end -->

                <div class="action-widget">
                  <h4 class="action-widget__title">@lang('Hotel Star Level')</h4>
                  <div class="action-widget__body">
                    @for ($star=1; $star <= $general->property_max_star; $star++)
                    <div class="form-check custom--checkbox d-flex justify-content-between">
                      <div class="left">
                        <input class="form-check-input star-lev-check" type="checkbox" value="{{ $star}}" id="starCheckbox-{{ $star }}">
                        <label class="form-check-label" for="starCheckbox-{{ $star }}">
                          {{ $star }} @lang('Stars')
                        </label>
                      </div>
                      <span class="fs--14px mt-1">(
                          @php
                              $propertyStars = $stars->where('star', $star)->first();
                          @endphp
                          {{ $propertyStars ? $propertyStars->total : 0 }}
                        )</span>
                    </div><!-- form-check end -->
                    @endfor
                  </div>
                </div><!-- action-widget end -->
                <div class="action-widget">
                  <h6 class="action-widget__title">@lang('Amenities')</h6>
                  <div class="action-widget__body scroll--active">
                    @foreach ($amenities as $amenity)
                    <div class="form-check custom--checkbox d-flex justify-content-between pe-2">
                      <div class="left">
                        <input class="form-check-input amenity-check" type="checkbox" value="{{ $amenity->id }}" id="checkbox-{{ $amenity->id }}">
                        <label class="form-check-label" for="checkbox-{{ $amenity->id }}">
                          @php
                              echo $amenity->icon;
                          @endphp  {{ __($amenity->name) }}
                        </label>
                      </div>
                    </div><!-- form-check end -->
                    @endforeach
                  </div>
                </div><!-- action-widget css end -->
              </div><!-- action-sidebar end -->
            </div>

            <div class="col-lg-9 mt-3">
              <div class="row align-items-center mb-3">
                <div class="col-md-9 col-sm-8">
                </div>
              </div>

              <div class="loader text-center">
                <div class="pre_loader"></div>
              </div>
              <div class="search-result">

                @forelse ($properties as $property)
                  @if(request()->date && ($property->rooms->count() <= $property->bookedRooms->count()))
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
                            @if($loop->iteration == 3) <li>@lang('And More')</li> @break @endif
                              <li>{{ __($feature) }}</li>
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
                        <p class="fs--14px mt-1">@lang('price per night')</p>
                        <a href="{{ route('property', [$property->id, slug($property->name)]) }}" class="btn btn-sm btn--base mt-3 w-100">@lang('View Details')</a>
                      </div>
                    </div>
                  </div><!-- hotel-card end -->
                @empty
                    <div class="text-center">
                      {{ __($emptyMessage) }}
                    </div>
                @endforelse
                <div class="text-end mt-4 pagination-md">
                  <ul class="pagination d-inline-flex">
                    {{ $properties->appends(request()->input())->links() }}
                  </ul>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
          <!-- search result section end -->

@endsection

@push('style')
    <style>
      .search-result {
        position: relative;
      }
      .loader{
        position: absolute;
        top: 40%;
        z-index: 999;
        left: 60%;
        display: none;
      }
      @media (max-width:991px) {
        .loader {
          left: 50%;
          top: 85%;
          transform: translate(-50% , -50%)
        }
      }
      .loader img{
        width: 30%;
      }

      .pre_loader{
        margin: 200px auto;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 15px solid white;
        border-top: 15px solid #1abc9c;
        animation: spin 2s linear infinite;
      }

      @keyframes spin{
        0%{
          transform: rotate(0deg);
        }
        100%{
          transform: rotate(360deg);
        }
      }
    </style>
@endpush

@push('script')
<script>
  (function ($) {
      "use strict";

        @if(!$request->date)
          $('.datepicker-here').datepicker();
        @endif
      var page = 1;

      var searchData = {};
      searchData.location = $('#location').val();
      searchData.date = $('#date').val();
      searchData.adult = $('#adult').val();
      searchData.child = $('#child').val();
      searchData.request = @json(request()->input());

      $(document).on('click', '.page-link', function(e){
        e.preventDefault();
        page = $(this).attr('href').match(/page=([0-9]+)/)[1];;
        loadSearch();
      });

      var sorting = '';
      var propertyType = '';
      var minPrice = 0;
      var maxPrice = 0;
      var paymentOptions = [];
      var starLevels = [];
      var amenities = [];
      var page = 1;

      $('.propertyType').on('change', function(e){
        propertyType = e.target.value;
        loadSearch();
      });

      $('#filter_btn').click(function(){
          minPrice = $('.min_price').val();
          maxPrice = $('.max_price').val();
          loadSearch();
      })

      $('.star-lev-check').click(function(e){
        starLevels = [];
        var starLevelArr = $('.star-lev-check:checked:checked');
        $.each(starLevelArr, function (indexInArray, valueOfElement) {
          starLevels.push(valueOfElement.value);
        });
          loadSearch();
      });

      $('.amenity-check').click(function(e){
        amenities = [];
        var amenityArr = $('.amenity-check:checked:checked');
        $.each(amenityArr, function (indexInArray, valueOfElement) {
          amenities.push(valueOfElement.value);
        });
          loadSearch();
      });


      function loadSearch(){
        $('.loader').css('display', 'block');
        $('.search-result').html('');
        var url = `{{ route('property.search.ajax') }}`;

        var data = { '_token': '{{ csrf_token() }}', 'sorting': sorting, 'propertyType': propertyType, 'minPrice': minPrice, 'maxPrice': maxPrice, 'paymentOptions': paymentOptions, 'starLevels': starLevels, 'amenities': amenities, 'searchData': searchData, 'page': page }

        $.ajax({
          type: "GET",
          url: url,
          data: data,
          success: function (response) {
            $('.loader').css('display', 'none');
           $('.search-result').html(response);
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
              alert("Status: " + textStatus); alert("Error: " + errorThrown);
          }

        });
      }

    })(jQuery);
</script>
@endpush
