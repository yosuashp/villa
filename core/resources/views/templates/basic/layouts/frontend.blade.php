<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link rel="icon" type="image/png" href="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" sizes="16x16">
    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lib/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <!--  -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lightcase.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lib/slick.css') }}">
    <!-- select 2 plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
    <!-- dateoicker css -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/datepicker.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color }}">
    @stack('style-lib')

    @stack('style')
</head>

<body>

    @stack('fbComment')

    @include($activeTemplate.'partials.preloader')
    <!-- header-section start  -->
    @include($activeTemplate.'partials.header')

    <div class="main-wrapper">
        @if (!request()->routeIs('home') && !request()->routeIs('property.details') && !request()->routeIs('property') && !request()->routeIs('property.category.rooms') && !request()->routeIs('property.category.rooms.date'))
        @include($activeTemplate.'partials.breadcrumb')
        @endif

        @yield('content')

    </div><!-- main-wrapper end -->


    <!-- footer section start -->
    @include($activeTemplate.'partials.footer')

    @include($activeTemplate.'partials.go_to_top')

    @php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp

    @if(@$cookie->data_values->status && !session('cookie_accepted'))
         <!-- cookies dark version start -->
        <div class="cookies-card bg--default text-center cookies--dark radius--10px">
        <div class="cookies-card__icon">
            <i class="fas fa-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content"> @php echo @$cookie->data_values->description @endphp <a class="d-inline" href="{{ @$cookie->data_values->link }}">@lang('Read Policy')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="{{ route('cookie.accept') }}" class="cookies-btn btn--base">Allow</a>
        </div>
        </div>
        <!-- cookies default end -->
    @endif

    @stack('modal')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset($activeTemplateTrue.'js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- slick slider js -->
    <script src="{{ asset($activeTemplateTrue.'js/lib/slick.min.js') }}"></script>
    <!-- scroll animation -->
    <script src="{{ asset($activeTemplateTrue.'js/lib/wow.min.js') }}"></script>
    <!-- lightcase js -->
    <script src="{{ asset($activeTemplateTrue.'js/lib/lightcase.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/global/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/datepicker.en.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue.'js/app.js') }}"></script>


    @include('partials.plugins')

    @include('partials.notify')

    @stack('script-lib')

    @stack('script')



    <script>
       (function ($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });

        })(jQuery);
    </script>

</body>

</html>
