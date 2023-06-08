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
                                <th>@lang('Owner')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($owners as $owner)
                            <tr>
                                <td data-label="@lang('Owner')">
                                    <span class="font-weight-bold">{{$owner->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.owners.detail', $owner->id) }}"><span>@</span>{{ $owner->username }}</a>
                                    </span>
                                </td>


                                <td data-label="@lang('Email-Phone')">
                                    {{ $owner->email }}<br>{{ $owner->mobile }}
                                </td>
                                <td data-label="@lang('Country')">
                                    <span class="font-weight-bold" data-toggle="tooltip" data-original-title="{{ @$owner->address->country }}">{{ $owner->country_code }}</span>
                                </td>


                                <td data-label="@lang('Joined At')">
                                    {{ showDateTime($owner->created_at) }} <br> {{ diffForHumans($owner->created_at) }}
                                </td>

                                <td data-label="@lang('Balance')">
                                    <span class="font-weight-bold">
                                        
                                    {{ $general->cur_sym }}{{ showAmount($owner->balance) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.owners.detail', $owner->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
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
                    {{ paginateLinks($owners) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{ route('admin.owners.search', $scope ?? str_replace('admin.owners.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Ownername or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
