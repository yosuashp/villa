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
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $key => $support)
                            <tr>
                                <td data-label="@lang('Subject')"> <a href="{{ route('owner.ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                <td data-label="@lang('Status')">
                                    @if($support->status == 0)
                                        <span class="badge badge--success">@lang('Open')</span>
                                    @elseif($support->status == 1)
                                        <span class="badge badge--primary">@lang('Answered')</span>
                                    @elseif($support->status == 2)
                                        <span class="badge badge--warning">@lang('Customer Reply')</span>
                                    @elseif($support->status == 3)
                                        <span class="badge badge--dark">@lang('Closed')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Priority')">
                                    @if($support->priority == 1)
                                        <span class="badge badge--dark">@lang('Low')</span>
                                    @elseif($support->priority == 2)
                                        <span class="badge badge--success">@lang('Medium')</span>
                                    @elseif($support->priority == 3)
                                        <span class="badge badge--primary">@lang('High')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('owner.ticket.view', $support->ticket) }}" class="icon-btn  ml-1">
                                        <i class="fa fa-desktop"></i>
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
                {{ paginateLinks($supports) }}
            </div>
        </div>
    </div>
</div>
@endsection
