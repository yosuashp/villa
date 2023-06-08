@extends('admin.layouts.app')

@section('panel')
<form action="{{ route('admin.property.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row">
        <div class="col-lg-8">
            <div class="card">              
                <div class="card-body">
                    <div class="payment-method-item">
                        <div class="payment-method-header">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview"
                                        style="background-image: url({{ getImage('/',imagePath()['property']['size']) }})">
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" name="image" class="profilePicUpload" id="image"
                                        accept=".png, .jpg, .jpeg" />
                                    <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                </div>
                            </div>
                            <div class="content">
                                <div class="form-group">
                                    <label class="w-100">@lang('Property Name') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('Property Name')" name="name" value="{{ old('name') }}" />
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="w-100">@lang('Property Type') <span class="text-danger">*</span></label>
                                            <select name="property_type" class="form-control">
                                                <option value="">@lang('Select One')</option>
                                                @foreach($propertyTypes as $propertyType)
                                                    <option value="{{ $propertyType->id }}">{{ __($propertyType->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="w-100">@lang('Location') <span
                                                    class="text-danger">*</span></label>
                                            <select name="location" class="form-control">
                                                <option value="">@lang('Select One')</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">{{ __($location->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="w-100">@lang('Select Stars') <span class="text-danger">*</span></label>
                                            <select name="star" class="form-control">
                                                <option value="">@lang('Select One')</option>
                                                @for ($star=1; $star <= $general->property_max_star; $star++)
                                                    <option value="{{ $star }}">{{ $star }} @lang('Stars')</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="w-100">@lang('Google Map Embed URL')</label>
                                    <textarea name="map_url" class="form-control" rows="4">{{ old('map_url') }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div><!-- card end -->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="w-100">@lang('Phone') <span class="text-danger">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="@lang('Enter phone number')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Phone Call Time') <span class="text-danger">*</span></label>
                        <input type="text" name="phone_call_time" value="{{ old('phone_call_time') }}" placeholder="@lang('Enter phone call time')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Discount')</label>
                        <div class="input-group">
                            <input type="number" name="discount" class="form-control" value="{{ old('discount') ?? 0 }}" min="0" step="any">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Owner Username') <span class="text-danger">*</span></label>
                        <input type="text" name="owner" value="{{ old('owner') }}" placeholder="@lang('Enter owner username')" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Extra Features')</label>
                        <select class="form-control select2" name="extra_features[]" multiple="multiple">
                        </select>
                        <small>@lang('Write feature then press enter')</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 pt-4">
            <div class="card">
                <h5 class="card-header bg--dark">@lang('Description') </h5>
                <div class="card-body">
                    <div class="form-group">
                        <textarea rows="5" class="form-control border-radius-5 nicEdit" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 pt-4">
            <div class="card border--dark">
                <h5 class="card-header bg--dark">@lang('Image Gallery')
                    <button type="button" class="btn btn-sm btn-outline-light float-right addImage">
                        <i class="la la-fw la-plus"></i>@lang('Add More Image')
                    </button>
                </h5>
                <div class="card-body">
                    <div class="row addedField"></div>
                </div>
            </div>
            <button type="submit" class="btn btn--primary btn-block mt-3">@lang('Save Property')</button>
        </div>
    </div>
</form>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.property.index') }}"
        class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> @lang('Go Back')
    </a>
@endpush

@push('style')
    <style>
        .payment_options_item{
            font-size: 0.85rem;
            font-weight: 600;
        }
        .payment-method-item .payment-method-header .thumb .avatar-edit{
            bottom: auto;
            top: 175px;
        }
        .image-upload .thumb .avatar-edit label{
            line-height: 36px;
            font-size: 14px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addImage').on('click', function () {
                var randomId = Math.floor(Math.random() * 10000);
                var html = `<div class="col-md-3 image-data">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('/', imagePath()['property']['size']) }})">
                                                </div>
                                            </div>
                                            <div class="avatar-edit my-2">
                                                <label for="${randomId}" class="bg--success">@lang('Upload Image')</label>
                                                <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                    @lang("Remove Image")
                                                </button>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 310x310px') </small>
                                                <input type="file" class="profilePicUpload" name="images[]" id="${randomId}" accept=".png, .jpg, .jpeg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                $('.addedField').append(html);
            });

            $(document).on('click', '.removeBtn', function(){
                $(this).closest('div.image-data').remove();
            });

            $('.select2').select2({
                tags: true
            });
        })(jQuery);
    </script>
@endpush
