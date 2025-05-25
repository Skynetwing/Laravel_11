<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="theme-name" content="Skynetwing" />
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="{{ asset('assets/plugins/material/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/simplebar.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/nprogress/nprogress.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css')}}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toaster/toastr.min.css')}}" rel="stylesheet" />
    <link id="main-css-href" rel="stylesheet" href="{{ asset('assets/css/style.css')}}" />
    <link href="{{ asset('assets/images/favicon.png')}}" rel="shortcut icon" />
    @yield('style')
    <script src="{{ asset('assets/plugins/nprogress/nprogress.js')}}"></script>
    <script>
        var siteUrl = "{{ url('/') }}";
    </script>
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <script src="{{ asset('assets/custom_js/active_class.js')}}"></script>
    <script>
        NProgress.configure({ showSpinner: false });
        NProgress.start();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="toaster"></div>
    <div class="wrapper">
        @include('layouts/sidebar_menu')
        <div class="page-wrapper">
            @include('layouts/header')
            <div class="m-2">
                @include('layouts/alert')
                @yield('content')
            </div>
            @include('layouts/footer')
        </div>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/simplebar/simplebar.min.js')}}"></script>
    {{--
    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js}"></script> --}}
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.js')}}"></script>
    <script src="{{ asset('assets/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea.js')}}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('input[name="dateRange"]').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
                jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
            });
            jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
                jQuery(this).val('');
            });
        });
    </script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('assets/plugins/toaster/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/js/mono.js')}}"></script>
    <script src="{{ asset('assets/js/chart.js')}}"></script>
    <script src="{{ asset('assets/js/map.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    @yield('script')
</body>

</html>
