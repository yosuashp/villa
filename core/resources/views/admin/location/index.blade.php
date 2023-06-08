@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Location')</th>
                                <th>@lang('Property')</th>
                                <th>@lang('Average Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ $locations->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Location')">{{ __($location->name) }}
                                    </td>
                                    <td data-label="@lang('Property')">{{ $location->properties->count() }}</td>
                                    <td data-label="@lang('Average Price')">{{ __($general->cur_sym) }}{{ showAmount($location->average_price) }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($location->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="icon-btn editLocation"
                                            data-id="{{ $location->id }}" data-name="{{ $location->name }}"
                                            data-average_price="{{ showAmount($location->average_price) }}"
                                            data-image="{{ getImage(imagePath()['location']['path'].'/'. $location->image, imagePath()['location']['size'])}}"
                                            data-status="{{ $location->status }}">
                                            <i class="la la-pen"></i></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <div class="card-footer py-4">
                {{ paginateLinks($locations) }}
            </div>
        </div>
    </div>
</div>


{{-- Location modal --}}
<div id="locationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')<span class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="text" name="name" class="form-control"
                                    placeholder="@lang('Enter your location')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Average Price')<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="average_price" class="form-control" min="0" step=".01">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">@lang('Image')</label>
                            <div class="oldImage">
                                <img src="" class="editImage">
                                <div class="text-center my-2">
                                    <button class="btn btn--danger btn-block btn-lg removeIt">@lang('Remove It')</button>
                                </div>
                            </div>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage('/', imagePath()['location']['size']) }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="locaton-image" accept=".png, .jpg, .jpeg">
                                        <label for="locaton-image" class="bg--success">@lang('Upload Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> </small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="old_image">
                        </div>
                        <div class="form-group statusGroup">
                            <label>@lang('Status')</label>
                            <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn--primary box--shadow1 text--small addLocation"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</button>
@endpush

@push('style')
    <style>
        .image-upload .thumb .avatar-edit label{
            line-height: 35px;
            font-size: 14px;
        }
        .oldImage{
            display: none;
        }
        .image-upload .thumb .profilePicPreview{
            height: 720px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addLocation').click(function(){
                var modal = $('#locationModal');
                var action = `{{ route('admin.location.store') }}`;
                modal.find('.modal-title').text("@lang('Add Location')");
                modal.find('.statusGroup').hide();
                modal.find('form').attr('action', action);
                $('.image-upload').css('display', 'block');
                modal.modal('show');
            })
            $('.editLocation').click(function () {
                var data = $(this).data();
                var modal = $('#locationModal');
                var action = `{{ route('admin.location.update', '') }}/${data.id}`;
                modal.find('.modal-title').text("@lang('Update Location')");
                modal.find('.statusGroup').show();
                modal.find('[name=name]').val(data.name);
                modal.find('[name=average_price]').val(data.average_price);
                if(data.status == 1){
                    modal.find('[name=status]').bootstrapToggle('on');
                }else{
                    modal.find('[name=status]').bootstrapToggle('off');
                }
                modal.find('.editImage').attr('src', data.image);
                modal.find('[name=old_image]').val(data.image);

                $('.oldImage').css('display', 'block');
                $('.image-upload').css('display', 'none');
                modal.find('form').attr('action', action);
                modal.modal('show')
            })

            $('.removeIt').click(function(e){
                e.preventDefault();
                $('[name=old_image]').val('');
                $('.image-upload').css('display', 'block');
                $('.oldImage').css('display', 'none');
            });

            $('#locationModal').on('hidden.bs.modal', function () {
                $('#locationModal form')[0].reset();
                $('.profilePicPreview').css('background-image', 'url({{ getImage('/', imagePath()['location']['size']) }})');
                $('.oldImage').css('display', 'none');
            });

        })(jQuery);
    </script>
@endpush
