@extends('owner.layouts.app')

@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-wallet"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{ showAmount($widget['balance']) }}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Available Balance')</span>
                </div>
                <a href="{{ route('owner.withdraw') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Withdraw Money')</a>
            </div>
        </div>
    </div><!-- dashboard-w1 end -->
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{$widget['total_properties']}}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Properties')</span>
                </div>
                <a href="{{route('owner.property.index')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--teal b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{$widget['total_rooms']}}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Rooms')</span>
                </div>
                <a href="{{route('owner.property.index')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View Properties')</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--green b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{$widget['total_room_category']}}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Room Categories')</span>
                </div>
                <a href="{{route('owner.property.room.category.index')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View Room Categoires')</a>
            </div>
        </div>
    </div>
</div>
@endsection
