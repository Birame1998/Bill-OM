<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @yield('headerStyle')



        <!-- App css -->
        <link href="{{ URL::asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

        <script src="{{ URL::asset('assets/js/jquery.min.js')}}"></script>
        <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/preload.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{ URL::asset('assets/js/jquery.bootstrap-growl.js') }}"></script>
        @yield('afterheaderStyle')

    </head>

    <body class="dark-sidenav">
    <!-- leftbar -->
    <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        @include('/layouts/header')

         <!-- toptbar -->
        @include('/layouts/sidebar')


        <div class="page-wrapper">

            <!-- Page Content-->
            <div class="page-content-tab">

                <!-- content -->
             @yield('content')

             <!-- extra Modal -->
             {{-- @include('../layouts/partials/extra-modal') --}}

              <!-- Footer -->
              @include('/layouts/footer')

            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- jQuery  -->

        <script src="{{ URL::asset('assets/js/jquery-ui.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/waves.js')}}"></script>
        <script src="{{ URL::asset('assets/js/preload.js')}}"></script>
        <script src="{{ URL::asset('assets/js/feather.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/jquery.slimscroll.min.js')}}"></script>
       <!-- footerScript -->
        @yield('footerScript')
        <!-- Parsley js -->
        <script src="{{ URL::asset('plugins/parsleyjs/parsley.min.js')}}"></script>
        <script src="{{ URL::asset('assets/pages/jquery.validation.init.js')}}"></script>
        <!-- App js -->
        <script src="../assets/js/jquery.core.js"></script>
        <!-- App js -->
        <script src="{{ URL::asset('assets/js/app.js')}}"></script>
        @yield('js_after')
    </body>

</html>
