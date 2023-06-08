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
                    <h2 class="as-title category-name">

                    </h2>
                    <div class="mt-5">
                        <h4 class="mb-3">@lang('Amenities')</h4>
                        <ul class="amenity-list">
                        </ul>
                    </div>

                    <div class="mt-5">
                        <div class="custom--card">
                            <div class="card-header">
                                <h4>@lang('Room List')</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive--md">
                                    <table class="table custom--table">
                                        <thead>
                                            <tr>
                                                <th>@lang('Room No.')</th>
                                                <th>@lang('Adult')</th>
                                                <th>@lang('Child')</th>
                                                <th>@lang('Price')</th>
                                                <th>@lang('Select')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body">
                                            @php $searchData = session()->get('search-data'); @endphp
                                                @if (!$searchData || ($searchData && $searchData['date'] == null))
                                                    <p class="text-danger my-3">@lang('** Select date to see available rooms.')</p>
                                                @else
                                                @foreach ($roomCategories as $category)
                                                    @foreach ($category->rooms as $room)
                                                        @if(!$category->bookedRooms->where('room_id',$room->id)->first())
                                                            <tr class="category-item {{ 'category-'.$category->id }}">
                                                                <td data-label="@lang('Room No.')" class="room_number">
                                                                {{ __($room->room_number) }}
                                                                </td>
                                                                <td data-label="@lang('Adult')">
                                                                    <ul class="as-rating-list justify-content-center mt-0">
                                                                        {{ __($room->adult) }}
                                                                    </ul>
                                                                </td>
                                                                <td data-label="@lang('Child')">
                                                                    <ul class="as-rating-list justify-content-center mt-0">
                                                                        {{ __($room->child) }}
                                                                    </ul>
                                                                </td>
                                                                <td data-label="@lang('Price')">
                                                                    <span class="d-block">
                                                                        {{ $general->cur_sym }}{{ showAmount($room->price) }}
                                                                    </span>
                                                                </td>
                                                                <td data-label="@lang('Select')">
                                                                    <div class="switch-button">
                                                                        <input type="checkbox" name="isSelectCheckbox[]" id="switch-label-{{ $room->id }}" class="switch-button__checkbox isSelect"
                                                                        data-id="{{ $room->id }}"
                                                                        data-room_number="{{ $room->room_number }}"
                                                                        data-adult="{{ $room->adult }}"
                                                                        data-child="{{ $room->child }}"
                                                                        data-price="{{ showAmount($room->price) }}"
                                                                        >
                                                                        <label for="switch-label-{{ $room->id }}" class="switch-button__label mb-0"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-lg-0 mt-4">
                    <div class="hotel-details-sidebar">
                        <div class="selected-room">
                            <h5 class="selected-room__title mb-3">@lang('Select Room Category')</h5>
                            <form action="#" class="row g-3">
                                <div class="col-12">
                                    <select class="form-select form--select roomCategories">
                                        @foreach ($roomCategories as $category)
                                            <option value="{{ $category->id }}" {{ $request->categoryId == $category->id ? 'selected':'' }}
                                                    data-category="{{ $category }}"
                                                >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn selected-room__btn w-100">
                                       @lang('Show Available Rooms')
                                    </button>
                                </div>
                            </form>
                        </div>
                                                 
                            <div class="mt-4">
                                <ul class="area-list room-list-header">
                                    <li class="area-list__item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block me-2">
                                                <i class="fas fa-hotel"></i>
                                            </span>
                                            <span class="d-inline-block fw-bold">
                                                @lang('Room No.')
                                            </span>
                                        </div>
                                        <span class="d-inline-block fw-bold">
                                            @lang('Price')
                                        </span>
                                    </li>
                                </ul>
                                <ul class="area-list room_list">
                                </ul>
                            </div>
                            <div class="mt-4">
                                <h5 class="selected-room__title mb-3 text-end">@lang('Total')</h5>
                                <ul class="area-list">
                                    <li class="area-list__item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block me-2">
                                                <i class="fas fa-user-alt"></i>
                                            </span>
                                            <span class="d-inline-block sm-text">
                                                @lang('Adult')
                                            </span>
                                        </div>
                                        <span class="d-inline-block sm-text selected_adult">
                                           @lang('0')
                                        </span>
                                    </li>
                                    <li class="area-list__item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block me-2">
                                                <i class="fas fa-child"></i>
                                            </span>
                                            <span class="d-inline-block sm-text">
                                                @lang('Child')
                                            </span>
                                        </div>
                                        <span class="d-inline-block sm-text selected_child">
                                           @lang('0')
                                        </span>
                                    </li>
                                    <li class="area-list__item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block me-2">
                                                <i class="fas fa-receipt"></i>
                                            </span>
                                            <span class="d-inline-block sm-text">
                                                @lang('Price')
                                            </span>
                                        </div>
                                        <span class="d-inline-block sm-text selected_total_price">
                                            {{ $general->cur_sym }}@lang('0')
                                        </span>
                                    </li>
                                </ul>
                                @if ($searchData && $searchData['date'] != null)
                                    <div class="text-end mt-3">
                                        <form action="{{ route('user.property.booking') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="date" value="{{ $searchData['date'] }}">
                                            <input type="hidden" name="room_list">
                                            <button type="submit" class="btn btn-md btn--base w-100">@lang('Pay Now')</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                     

                        <div class="mt-4">
                            <form action="{{ route('property.category.rooms.date', [$property->id, slug($property->name)]) }}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('Checkin - Checkout')</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg--base text-white"><i class="las la-calendar-check"></i></span>
                                        <input type="text" data-range="true" name="date" data-multiple-dates-separator=" - "
                                            data-language="en" class="datepicker-here form--control" id="date"
                                            placeholder="Checkin & Checkout" autocomplete="off" value="{{ ($searchData && $searchData['date'] != null) ? $searchData['date'] : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Search')</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hotel deatils section end -->
@endsection


@push('script')
<script>
    (function ($) {
        "use strict";

        var curSym = '{{ $general->cur_sym }}';

        @if(!$searchData || $searchData['date'] == null)
          $('.datepicker-here').datepicker();
        @endif


        $(document).on('change', '.isSelect', function(){
            var totalPrice = 0;
            var totalAdult = 0;
            var totalChild = 0;
            var discountPrice = 0;
            var roomList = [];

            $('.selected_room_number').html('');
            $('.selected_adult').text('');
            $('.selected_child').text('');
            $('.selected_total_price').text('');
            $('.selected_discount_price').text('');
            $('[name=room_list]').val('');
            $('.room_list').html('');

            $("input:checkbox:checked").each(function (index) {
                var data = $(this).data();
                var roomPrice = parseFloat(data.price);
                totalPrice += roomPrice;
                discountPrice += parseFloat(data.discount_price);
                roomList.push(data.id);
                totalAdult += data.adult;
                totalChild += data.child;

                $('.room_list').append(`
                    <li class="area-list__item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block sm-text">
                                ${data.room_number}
                            </span>
                        </div>
                        <span class="d-inline-block sm-text">
                            ${curSym+roomPrice.toFixed(2)}
                        </span>
                    </li>
                `);

                $('.selected_room_number').append(index+1+'. '+data.room_number+'<br>');

                $('[name=room_list]').val(roomList);

            });

            $('.selected_adult').text(totalAdult);
            $('.selected_child').text(totalChild);
            $('.selected_total_price').text(curSym+totalPrice.toFixed(2));
            $('.selected_discount_price').text(curSym+discountPrice.toFixed(2));


        });

        $('.selected-room__btn').click(function(e){
            e.preventDefault();
        });

        $('.roomCategories').change(function(e){
            var category = $(this).find(':selected').data('category');
            $('.category-name').text(category.name);
            $('.amenity-list').text('');
            category.amenities.forEach(amenity => {
                $('.amenity-list').append(`<li class="amenity-list__item"><span class="amenity__icon">${amenity.icon}</span><span class="amenity__text">${amenity.name}</span></li>`);
            });
            var roomCategory = e.target.value;
            $('.category-item').css('display', 'none');
            $('.category-'+roomCategory).css('display', 'table-row');

        }).change();

    })(jQuery);

    </script>
@endpush

@push('style')
    <style>
        .room_list {
            border-top: none;
        }
        .room_list li:nth-child(odd) {
            background: #fff;
        }
        .room_list li:nth-child(even) {
            background: #f5f5f5;
        }
        .room-list-header {
            border-bottom: none;
            padding-bottom: 0;
        }
    </style>
@endpush
