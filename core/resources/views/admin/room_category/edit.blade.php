@extends('admin.layouts.app')

@section('panel')
<form action="{{ route('admin.property.room.category.update', $roomCategory->id) }}" method="POST">
    @csrf
<div class="row">
        <div class="col-lg-8">
            <div class="card">              
                <div class="card-body">
                    <div class="form-group">
                        <label class="w-100">@lang('Room Category') <span class="text-danger">*</span></label>
                        <input type="text" name="room_category" class="form-control" value="{{ $roomCategory->name }}">
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Property Name') <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  value="{{ $roomCategory->property->name }}" disabled>
                    </div>
                </div>
            </div><!-- card end -->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="w-100">@lang('Amenities') <span class="text-danger">*</span></label>
                        @foreach($amenities as $amenity)
                            <div>
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="{{ $amenity->id }}"
                                    @foreach ($roomCategory->amenities as $am)
                                        {{ $am == null ? '' : $am->id == $amenity->id ? 'checked':'' }}
                                    @endforeach
                                >
                                <label for="{{ $amenity->id }}" class="amenity-item">{{ __($amenity->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 pt-4">
            <div class="card border--dark">
                <h5 class="card-header bg--dark">@lang('Room List')
                    <button type="button" class="btn btn-sm btn-outline-light float-right addRoom" data-currency="{{ __($general->cur_text) }}">
                        <i class="la la-fw la-plus"></i>@lang('Add More Room')
                    </button>
                </h5>
                <div class="card-body">
                    <div class="addedField">
                        @foreach ($roomCategory->rooms as $room)
                            <div class="row room-list">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="old_room_number[]" value="{{ $room->room_number }}" class="form-control" placeholder="@lang('Room number')">
                                    </div>
                                </div>
                                <input type="hidden" name="old_room_id[]" value="{{ $room->id }}">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" name="old_adult[]" value="{{ $room->adult }}" min="1" step="1" class="form-control" placeholder="@lang('Adult')">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" name="old_child[]"  value="{{ $room->child }}" min="0" step="1" class="form-control" placeholder="@lang('Child')">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="number" name="old_price[]"  value="{{ getAmount($room->price) }}" min="0" step="any" class="form-control" placeholder="@lang('Price')">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status_{{ $room->id }}" @if ($room->status == 1) checked @endif>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Save Room Category')</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.property.room.category.index') }}"
        class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> @lang('Go Back')
    </a>
@endpush

@push('style')
    <style>
        .amenity-item{
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addRoom').on('click', function () {
                var randomId = Math.floor(Math.random() * 10000);
                var html = `
                    <div class="row room-list">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="room_number[]" class="form-control" placeholder="@lang('Room number')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="number" name="adult[]" min="1" step="1" class="form-control" placeholder="@lang('Adult')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="number" name="child[]" min="0" step="1" class="form-control" placeholder="@lang('Child')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="number" name="price[]" min="0" step="1" class="form-control" placeholder="@lang('Price')">
                                <div class="input-group-append">
                                    <span class="input-group-text">${$(this).data('currency')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span class="input-group-btn">
                                <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>`;

                $('.addedField').append(html);
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.room-list').remove();
            });
        })(jQuery);
    </script>
@endpush
