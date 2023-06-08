@extends('admin.layouts.app')

@section('panel')
<form action="{{ route('admin.property.update', $property->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                    <div class="card-body">
                        <div class="payment-method-item">
                            <div class="payment-method-header">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['property']['path'].'/'.$property->image,imagePath()['property']['size'])}})"></div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" name="image" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg"/>
                                        <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="form-group">
                                        <label class="w-100">@lang('Property Name') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="@lang('Property Name')" name="name" value="{{ $property->name }}"/>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                               <label class="w-100">@lang('Property Type') <span class="text-danger">*</span></label>
                                                   <select name="property_type" class="form-control">
                                                       <option value="">@lang('Select One')</option>
                                                       @foreach ($propertyTypes as $propertyType)
                                                           <option value="{{ $propertyType->id }}" {{ $property->property_type_id == $propertyType->id ? 'selected':'' }}>{{ __($propertyType->name) }}</option>
                                                       @endforeach
                                                   </select>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                           <div class="form-group">
                                               <label class="w-100">@lang('Location') <span class="text-danger">*</span></label>
                                                   <select name="location" class="form-control">
                                                       <option value="">@lang('Select One')</option>
                                                       @foreach ($locations as $location)
                                                           <option value="{{ $location->id }}" {{ $property->location_id == $location->id ? 'selected' : '' }}>{{ __($location->name) }}</option>
                                                       @endforeach
                                                   </select>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="w-100">@lang('Select Stars') <span class="text-danger">*</span></label>
                                                <select name="star" class="form-control">
                                                    <option value="">@lang('Select One')</option>
                                                    @for($star=1; $star <= $general->property_max_star; $star++)
                                                        <option value="{{ $star }}" {{ $star == $property->star ? 'selected':'' }}>{{ $star }} @lang('Stars')</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="w-100">@lang('Extra Features')</label>
                                                <select class="form-control select2" name="extra_features[]" multiple="multiple">
                                                    @if ($property->extra_features)    
                                                        @foreach($property->extra_features as $feature)
                                                            <option value="{{$feature}}" selected="true">{{__($feature)}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <small>@lang('Write feature then press enter')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                     <div class="col-md-12">
                                         <div class="form-group">
                                             <label class="w-100">@lang('Google Map Embed URL')</label>
                                             <textarea name="map_url" class="form-control" rows="4">{{ $property->map_url }}</textarea>
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
                        <input type="text" name="phone" value="{{ $property->phone }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Phone Call Time') <span class="text-danger">*</span></label>
                        <input type="text" name="phone_call_time" value="{{ $property->phone_call_time }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Discount')</label>
                        <div class="input-group">
                            <input type="number" name="discount" class="form-control" value="{{ getAmount($property->discount) }}" min="0" step="any">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Owner')</label>
                        <input type="text" value="{{ $property->owner->fullname }} - {{ $property->owner->username }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label class="w-100">@lang('Is Top Reviewed')</label>
                        <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" data-width="100%" name="top_reviewed" @if ($property->top_reviewed == 1) checked @endif>
                    </div>

                    <div class="form-group">
                        <label class="w-100">@lang('Status')</label>
                        <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status" @if ($property->status == 1) checked @endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 pt-4">
            <div class="card border--dark my-2">
                <h5 class="card-header bg--dark">@lang('Description') </h5>
                <div class="card-body">
                    <div class="form-group">
                        <textarea rows="5" class="form-control border-radius-5 nicEdit" name="description">{{ $property->description }}</textarea>
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
                    <div class="row addedField">
                        @foreach ($property->images as $image)
                        <div class="col-md-3 image-data">
                            <div class="form-group">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['property']['path'].'/'.$image, imagePath()['property']['size']) }})">
                                            </div>
                                        </div>
                                        <div class="text-center my-2">
                                            <label for="{{ 'id-'.$image }}" class="btn btn--success btn-block btn-lg">@lang('Change Image')</label>
                                            <button class="btn btn--danger btn-block btn-lg removeIt"
                                                data-image="{{ $image }}"
                                            >@lang('Remove Image')</button>
                                            <input type="file" class="profilePicUpload" data-old_image="{{ $image }}" id="{{ 'id-'.$image }}" name="change_images[]" accept=".png, .jpg, .jpeg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="old_images">
                </div>
            </div>
            <button type="submit" class="btn btn--primary btn-block mt-3">@lang('Save Property')</button>
        </div>
    </div>
</form>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.property.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> @lang('Go Back')
    </a>
@endpush

@push('style')
    <style>
        .image-upload .thumb .avatar-edit label{
            line-height: 36px;
            font-size: 14px;
        }
        .payment-method-item .payment-method-header .thumb .avatar-edit{
            bottom: auto;
            top: 175px;
        }
        .payment_options_item{
            font-size: 0.85rem;
            font-weight: 600;
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

            $(document).on('click', '.remove-image', function () {
                $(this).closest('.image-data').remove();
            });

            var images = @json($property->images);
            $('[name="old_images"]').val(images);

            $('.removeIt').click(function(e){
                e.preventDefault();
                $(this).closest('div.image-data').css('display', 'none');
                var image = $(this).data('image');
                images.splice($.inArray(image, images), 1);
                console.log(images);
                $('[name="old_images"]').val(images);
            });

            $(document).on('click', '.removeBtn', function(){
                $(this).closest('div.image-data').remove();
            });

             
            $(".profilePicUpload").on('change', function () {
                var image = $(this).data('old_image');
                images.splice($.inArray(image, images), 1);
                $('[name="old_images"]').val(images);
            });

            $('.select2').select2({
                tags: true
            });

        })(jQuery);
    </script>
@endpush
