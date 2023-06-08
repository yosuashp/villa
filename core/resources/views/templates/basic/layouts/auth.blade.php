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

    @include($activeTemplate.'partials.preloader')

    <div class="main-wrapper">

        @yield('content')

    </div><!-- main-wrapper end -->

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

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";

        })(jQuery);

    </script>

</body>

</html>
