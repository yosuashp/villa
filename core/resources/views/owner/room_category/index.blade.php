@extends('owner.layouts.app')
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
                                <th>@lang('Property')</th>
                                <th>@lang('Rooms')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roomCategories as $roomCategory)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ $roomCategories->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Name')">{{ __($roomCategory->name) }}</td>
                                    <td data-label="@lang('Property')">{{ __($roomCategory->property->name) }}</td>
                                    <td data-label="@lang('Rooms')">{{ __($roomCategory->rooms->count()) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('owner.property.room.category.edit', $roomCategory->id) }}" class="icon-btn ml-1"><i class="la la-pen"></i></i></a>
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
                {{ paginateLinks($roomCategories) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('owner.property.room.category.create') }}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush