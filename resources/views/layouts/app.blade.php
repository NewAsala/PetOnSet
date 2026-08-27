<!DOCTYPE html>
<html lang="en" dir="rtl" data-scompiler-id="0">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>Stroyka Admin - eCommerce Dashboard Template</title>
    <!-- icon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- fonts -->
    <link rel="stylesheet" href={{ asset('font/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i') }}>
    <!-- css -->
    <link rel="stylesheet" href={{ asset('vendor/bootstrap/css/bootstrap.rtl.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/highlight.js/styles/github.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/simplebar/simplebar.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/quill/quill.snow.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/air-datepicker/css/datepicker.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/select2/css/select2.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/nouislider/nouislider.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendor/fullcalendar/main.min.css') }}>
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
    <script async src={{ asset('gtag/js?id=UA-97489509-8') }}></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-97489509-8');
    </script>
</head>

<body>
    <div class="sa-app sa-app--desktop-sidebar-shown sa-app--mobile-sidebar-hidden sa-app--toolbar-fixed">

        @include('layouts.sidebar')

        <div class="sa-app__content">
            <!-- sa-app__toolbar -->
            @include('layouts.header')

            <!-- sa-app__body -->
            <div id="top" class="sa-app__body px-2 px-lg-4">
                <div class="container pb-6">
                    @yield('content')
                </div>
            </div><!-- sa-app__body / end -->
            <!-- sa-app__footer -->
            @include('layouts.footer')

        </div><!-- sa-app__content / end -->

        <!-- sa-app__toasts -->
        <div class="sa-app__toasts toast-container bottom-0 end-0"></div>

    </div>
    <!-- scripts -->
    <script src={{ asset('vendor/jquery/jquery.min.js') }}></script>
    <script src={{ asset('vendor/feather-icons/feather.min.js') }}></script>
    <script src={{ asset('vendor/simplebar/simplebar.min.js') }}></script>
    <script src={{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('vendor/highlight.js/highlight.pack.js') }}></script>
    <script src={{ asset('vendor/quill/quill.min.js') }}></script>
    <script src={{ asset('vendor/air-datepicker/js/datepicker.min.js') }}></script>
    <script src={{ asset('vendor/air-datepicker/js/i18n/datepicker.en.js') }}></script>
    <script src={{ asset('vendor/select2/js/select2.min.js') }}></script>
    <script src={{ asset('vendor/fontawesome/js/all.min.js') }} data-auto-replace-svg async></script>
    <script src={{ asset('vendor/chart.js/chart.min.js') }}></script>
    <script src={{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}></script>
    <script src={{ asset('vendor/nouislider/nouislider.min.js') }}></script>
    <script src={{ asset('vendor/fullcalendar/main.min.js') }}></script>
    <script src={{ asset('js/stroyka.js') }}></script>
    <script src={{ asset('js/custom.js') }}></script>
    <script src={{ asset('js/calendar.js') }}></script>
    <script src={{ asset('js/demo.js') }}></script>
    <script src={{ asset('js/demo-chart-js.js') }}></script>
</body>

</html>
