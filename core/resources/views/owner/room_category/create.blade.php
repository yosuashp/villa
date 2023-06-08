@extends('owner.layouts.app')

@section('panel')
<form action="{{ route('owner.property.room.category.store') }}" method="POST">
    @csrf
<div class="row">
        <div class="col-lg-8">
            <div class="card">              
                <div class="card-body">
                    <div class="form-group">
                        <label class="w-100">@lang('Room Category') <span class="text-danger">*</span></label>
                        <input type="text" name="room_category" class="form-control" value="{{ old('room_category') }}">
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Property Name') <span class="text-danger">*</span></label>
                        <select name="property" class="form-control">
                            <option value="">@lang('Select one')</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
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
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="{{ $amenity->id }}">
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
                    <div class="addedField"></div>
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
    <a href="{{ route('owner.property.room.category.index') }}"
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
        @media (max-width: 767px) {
            .removeBtn{
                margin: 15px 0 40px 0;
            }
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
                        <div class="col-xl-4 col-md-3">
                            <div class="form-group">
                                <input type="text" name="room_number[]" class="form-control" placeholder="@lang('Room number')">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="adult[]" min="1" step="1" class="form-control" placeholder="@lang('Adult')">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="child[]" min="0" step="1" class="form-control" placeholder="@lang('Child')">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <div class="input-group">
                                <input type="number" name="price[]" min="0" step="any" class="form-control" placeholder="@lang('Price')">
                                <div class="input-group-append">
                                    <span class="input-group-text">${$(this).data('currency')}</span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2">
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
