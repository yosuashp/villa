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
                                <th>@lang('Name')</th>
                                <th>@lang('Icon')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($amenities as $amenity)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ $amenities->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Name')">{{ __($amenity->name) }}</td>
                                    <td data-label="@lang('Icon')">@php
                                        echo $amenity->icon;
                                    @endphp</td>
                                    <td data-label="@lang('Status')">
                                        @if($amenity->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="icon-btn updateAmenityModal"
                                            data-id="{{ $amenity->id }}"
                                            data-name="{{ $amenity->name }}"
                                            data-icon="{{ $amenity->icon }}"
                                            data-status="{{ $amenity->status }}">
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
                {{ paginateLinks($amenities) }}
            </div>
        </div>
    </div>
</div>

{{-- Amenity modal --}}
<div id="amenityModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Icon')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" class="form-control icon" name="icon" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Name')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" name="name" class="form-control" placeholder="@lang('Enter your amenity')" required>
                        </div>
                    </div>
                    <div class="form-group statusGroup">
                        <label>@lang('Status')</label>
                        <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle"
                            data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status">
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
    <button type="button" class="btn btn-sm btn--primary box--shadow1 text--small addAmenityModal"><i
            class="fa fa-fw fa-plus"></i>@lang('Add New')</button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/laramin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addAmenityModal').click(function () {
                var modal = $('#amenityModal');
                var action = `{{ route('admin.amenity.store') }}`;
                modal.find('.modal-title').text("@lang('Add Amenity')");
                modal.find('.statusGroup').hide();
                modal.find('form').attr('action', action);
                modal.modal('show')
            });
            $('.updateAmenityModal').click(function () {
                var data = $(this).data();
                var modal = $('#amenityModal');
                var action = `{{ route('admin.amenity.update', '') }}/${data.id}`;
                modal.find('.modal-title').text("@lang('Update Amenity')");
                modal.find('.statusGroup').show();
                modal.find('[name=name]').val(data.name);
                modal.find('[name=icon]').val(data.icon);
                if (data.status == 1) {
                    modal.find('[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('[name=status]').bootstrapToggle('off');
                }
                modal.find('form').attr('action', action);
                modal.modal('show')
            })
            $('#amenityModal').on('hidden.bs.modal', function () {

                console.log($('#amenityModal form')[0].reset());
                $('#amenityModal form')[0].reset();
            });
            $('.iconPicker').iconpicker().on('change', function (e) {
                $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
            });
        })(jQuery);

    </script>
@endpush