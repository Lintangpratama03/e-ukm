<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/icon.png') }}">
    <title>E-UKM Polinema Kediri</title>

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="{{ asset('landing-page/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('landing-page/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="{{ asset('landing-page/assets/css/material-kit.css?v=3.1.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
</head>

<body class="index-page bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.landing-page.navbar')
            </div>
        </div>
    </div>
    <header class="header-2">
        <div class="page-header min-vh-75 relative"
            style="background-image: url('{{ asset('landing-page/assets/img/bg-landing.JPG') }}')" ">
            <span class="mask bg-gradient-dark opacity-4"></span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 text-center mx-auto">
                        <h1 class="text-white font-weight-black pt-3 mt-n5">UKM POLINEMA KEDIRI</h1>
                        <p class="lead text-white mt-3" style="font-size: 0.8rem !important;">Unit Kegiatan Mahasiswa
                            atau
                            dikenal
                            dengan UKM, Unit Kegiatan
                            Mahasiswa (UKM) adalah salah satu unsur yang tak terpisahkan dari kehidupan mahasiswa di
                            perguruan tinggi. UKM merupakan organisasi atau kelompok kecil yang terdiri dari mahasiswa
                            dengan minat dan tujuan bersama dalam bidang tertentu, seperti olahraga, seni,
                            kewirausahaan, atau sosial.</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

        @yield('content')


    <footer class="footer pt-5">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="text-center">
                        <p class="text-dark my-4 text-sm font-weight-normal">
                            All rights reserved. Copyright © Huda Dirgantara
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
     <!-- Include DataTables CSS and JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
 
    <!--   Core JS Files   -->
    <script src="{{ asset('landing-page/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing-page/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing-page/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>

    <!-- Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="{{ asset('landing-page/assets/js/plugins/countup.min.js') }}"></script>

    <script src="{{ asset('landing-page/assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/plugins/prism.min.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/plugins/highlight.min.js') }}"></script>

    <!-- Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
    <script src="{{ asset('landing-page/assets/js/plugins/rellax.min.js') }}"></script>
    <!-- Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
    <script src="{{ asset('landing-page/assets/js/plugins/tilt.min.js') }}"></script>
    <!-- Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
    <script src="{{ asset('landing-page/assets/js/plugins/choices.min.js') }}"></script>

    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages, etc -->
    <!-- Google Maps Plugin -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="{{ asset('landing-page/assets/js/material-kit.min.js?v=3.1.0') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>
    
    <script src="{{ asset('assets') }}/js/vendor/fullcalendar.min.js"></script>
    @yield('script')
</body>

</html>
