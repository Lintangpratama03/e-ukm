<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>E-UKM | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/icon.png">

    <!-- Datatables css -->
    <link href="{{ asset('assets') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

    {{-- third party datatable --}}
    <link href="{{ asset('assets') }}/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/fixedHeader.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/fixedColumns.bootstrap5.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

</head>

<body class="loading" data-layout-color="light" data-layout="detached" data-rightbar-onstart="true">
    <!-- Start Content-->
    @include('layouts.topbar')
    <div class="container-fluid">

        <!-- Begin page -->
        <div class="wrapper">
            @include('layouts.sidebar')
            <div class="content-page">
                <div class="content">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Huda Digantara
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>
            <!-- content-page -->

        </div> <!-- end wrapper-->
    </div>
    <!-- END Container -->


    <script src="{{ asset('assets') }}/js/vendor.min.js"></script>
    <script src="{{ asset('assets') }}/js/app.min.js"></script>

    <!-- Datatables js -->
    <script src="{{ asset('assets') }}/js/vendor/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/responsive.bootstrap5.min.js"></script>

    {{-- third party datatable --}}
    <script src="{{ asset('assets') }}/js/vendor/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/buttons.bootstrap5.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/buttons.flash.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/dataTables.select.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/fixedColumns.bootstrap5.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/fixedHeader.bootstrap5.min.js"></script>

    <!-- Datatable Init js -->
    <script src="{{ asset('assets') }}/js/pages/demo.datatable-init.js"></script>
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- notiflix --}}
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.6/dist/notiflix-aio-3.2.6.min.js"></script>

    <script>
        function confirm_logout() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan keluar dari aplikasi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "";
                }
            })
        }
    </script>

    @yield('script')

</body>

</html>
