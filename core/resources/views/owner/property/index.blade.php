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
                                <th>@lang('Property Type')</th>
                                <th>@lang('Location')</th>
                                <th>@lang('Discount')</th>
                                <th>@lang('Room')</th>
                                <th>@lang('Categories')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($properties as $property)
                                <tr>
                                    <td data-label="@lang('S.N.')"> {{ $properties->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Name')">{{ __($property->name) }}</td>
                                    <td data-label="@lang('Property Type')">{{ __($property->propertyType->name) }}</td>
                                    <td data-label="@lang('Location')">{{ __($property->location->name) }}</td>
                                    <td data-label="@lang('Discount')">{{ showAmount($property->discount) }}%</td>
                                    <td data-label="@lang('Room')">{{ $property->rooms->count() }}</td>
                                    <td data-label="@lang('Categories')">
                                        <a href="{{ route('owner.property.room.category.property', [slug($property->name), $property->id]) }}" class="icon-btn btn--info ml-1">
                                            {{ $property->roomCategories->count() }}
                                        </a>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($property->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('owner.property.edit', $property->id) }}" class="icon-btn ml-1"><i class="la la-pen"></i></i></a>
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
                {{ paginateLinks($properties) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('owner.property.create') }}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush