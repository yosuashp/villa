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
                                <th>@lang('Property')</th>
                                <th>@lang('Check In')</th>
                                <th>@lang('Check Out')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Price')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bookedProperties as $bookedProperty)
                            <tr>
                                <td data-label="@lang('Property')">{{ __($bookedProperty->property->name) }}</td>
                                <td data-label="@lang('Check In')">{{ $bookedProperty->date_from }}</td>
                                <td data-label="@lang('Check Out')">{{ $bookedProperty->date_to }}</td>
                                <td data-label="@lang('Phone')">{{ __($bookedProperty->property->phone) }}</td>
                                <td data-label="@lang('Price')">{{ showAmount($bookedProperty->total_price) }}</td>
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
                    {{ paginateLinks($bookedProperties) }}
                </div>
            </div>
        </div>


    </div>
@endsection