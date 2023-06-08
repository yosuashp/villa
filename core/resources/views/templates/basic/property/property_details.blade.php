@extends($activeTemplate.'layouts.frontend')
@section('content')
    <!-- hotel deatils section start -->
    <section class="pb-100">
        <div class="hotel-details-thumb-slider">
            <div class="single-slide">
                <div class="hotel-details-thumb">
                    <a href="{{ getImage(imagePath()['property']['path'] . '/' . $property->image, imagePath()['property']['size']) }}"
                        class="lightcase full-view" data-rel="lightcase"><i class="las la-image"></i>@lang('See Full View')
                    </a>
                    <img src="{{ getImage(imagePath()['property']['path'] . '/' . $property->image, imagePath()['property']['size']) }}"
                        alt="image">
                </div>
            </div><!-- single-slide end -->
            @foreach ($property->images as $image)
                <div class="single-slide">
                    <div class="hotel-details-thumb">
                        <a href="{{ getImage(imagePath()['property']['path'] . '/' . $image, imagePath()['property']['size']) }}"
                            class="lightcase full-view" data-rel="lightcase"><i class="las la-image"></i>@lang('See Full
                            View')
                        </a>
                        <img src="{{ getImage(imagePath()['property']['path'] . '/' . $image, imagePath()['property']['size']) }}"
                            alt="image">
                    </div>
                </div><!-- single-slide end -->
            @endforeach
        </div><!-- hotel-details-thumb-slider end -->
        <div class="container pt-50">
            <div class="row">
                <div class="col-lg-8">

                    <ul class="nav hotel-nav">
                        <li class="hotel-nav__item">
                            <button class="nav-link w-100 hotel-nav__btn active" data-bs-toggle="pill"
                                data-bs-target="#hotel-description" type="button">@lang('Description')</button>
                        </li>
                        <li class="hotel-nav__item">
                            <button class="nav-link w-100 hotel-nav__btn" data-bs-toggle="pill"
                                data-bs-target="#hotel-category" type="button">@lang('Rooms')</button>
                        </li>
                        <li class="hotel-nav__item">
                            <button class="nav-link w-100 hotel-nav__btn" data-bs-toggle="pill"
                                data-bs-target="#hotel-review" type="button">@lang('Review')</button>
                        </li>
                        <li class="hotel-nav__item">
                            <button class="nav-link w-100 hotel-nav__btn" data-bs-toggle="pill"
                                data-bs-target="#hotel-location" type="button">@lang('Location')</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include($activeTemplate.'property.property_details_description')
                        @include($activeTemplate.'property.property_details_rooms')
                        @include($activeTemplate.'property.property_details_reviews')
                        @include($activeTemplate.'property.property_details_location')
                    </div>
                </div>
                <div class="col-lg-4 mt-lg-0 mt-4">
                    <div class="hotel-details-sidebar">
                        <div class="reserve-widget">
                            <div class="top text-center">
                                @if ($property->discount != 0)
                                    <div class="hotel-details-offer-badge">
                                        <b>{{ $property->discount }}%</b> <br>
                                        <span>@lang('off')</span>
                                    </div>
                                @endif
                                <h4>{{ $property->star }} @lang('star hotel')</h4>
                                @if (count($property->rooms))
                                    <div class="price">
                                        @if ($property->discount != 0)
                                            <del>{{ $general->cur_sym }} {{ showAmount($lowestRoomPrice) }}</del>
                                            <span
                                                class="text--base">{{ $general->cur_sym }}{{ showAmount(($lowestRoomPrice * (100 - $property->discount)) / 100) }}</span>
                                            <sub>/ @lang('per night')</sub>
                                        @else
                                            <span class="text--base">{{ $general->cur_sym }}
                                                {{ showAmount($lowestRoomPrice) }}</span>
                                        @endif
                                    </div>
                                @else
                                    <p>@lang('No room found')</p>
                                @endif
                            </div>
                            @if (isset($request))
                                @if ($request->location && $request->date && $request->adult)
                                    <form action="{{ route('property.rooms') }}">
                                        <input type="hidden" name="property" value="{{ $property->id }}">
                                        <input type="hidden" name="location" value="{{ $request->location }}">
                                        <input type="hidden" name="date" value="{{ $request->date }}">
                                        <input type="hidden" name="adult" value="{{ $request->adult }}">
                                        <input type="hidden" name="child" value="{{ $request->child }}">
                                    </form>
                                @else
                                    <form action="{{ route('property.rooms') }}">
                                        <input type="hidden" name="property" value="{{ $property->id }}">
                                        <input type="hidden" name="location" value="{{ $request->location }}">
                                        <input type="hidden" name="date" value="{{ $request->date }}">
                                        <input type="hidden" name="adult" value="{{ $request->adult }}">
                                        <input type="hidden" name="child" value="{{ $request->child }}">
                                        <button type="submit" class="btn btn--base w-100 mt-4">@lang('Sell All
                                            Rooms')</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="book-widget mt-4 text-center text-white">
                            <i class="las la-phone-volume"></i>
                            <h3 class="text-white mt-2">@lang('Book by phone')</h3>
                            <a href="tel:45455" class="fs--18px text--base mt-3 mb-1">{{ $property->phone }}</a>
                            <p class="text-white fs--14px">{{ $property->phone_call_time }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hotel deatils section end -->
@endsection
