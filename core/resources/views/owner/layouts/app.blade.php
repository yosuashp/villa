@extends('owner.layouts.master')

@section('content')
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('owner.partials.sidenav')
        @include('owner.partials.topnav')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                @include('owner.partials.breadcrumb')

                @yield('panel')


            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>
@endsection

@push('style')
    <style>
     @media (max-width: 991px) {
        .fullscreen-btn{
            display: none;
        }
    }
    </style>
@endpush
