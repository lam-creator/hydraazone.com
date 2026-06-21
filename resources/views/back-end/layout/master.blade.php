<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle')</title>

    <!-- CORE CSS -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/back-end/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/back-end/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/back-end/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/back-end/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/back-end/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/back-end/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/back-end/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/back-end/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/back-end/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- JQUERY LATEST -->
    <script src="/back-end/plugins/jquery/jquery.min.js"></script>
    @stack('stylesheets')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('back-end/layout/navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @if (Auth::guard('admin')->check())
        @include('back-end/layout/admin-sidebar')
        @endif

        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="mt-2 content">
                <div class="container-fluid">

                    @yield('content')

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#">BD Dairy</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- CORE JS -->
    <script src="/back-end/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/back-end/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/back-end/plugins/select2/js/select2.full.min.js"></script>
    <script src="/back-end/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/back-end/plugins/jquery-form/jquery.form.min.js"></script>
    <script src="/back-end/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/back-end/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- PAGE LEVEL JS -->
    <script src="/back-end/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/back-end/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/back-end/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/back-end/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/back-end/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/back-end/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/back-end/plugins/jszip/jszip.min.js"></script>
    <script src="/back-end/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/back-end/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/back-end/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- CORE MAIN JS -->
    <script src="/back-end/dist/js/adminlte.min.js"></script>

    <!-- Page specific script -->
    <script>
    $(document).ready(function() {

        // csrf token for laravel ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        // Summernote
        $('#summernote').summernote({
            height: 200, // set editor height
            minHeight: 100, // set minimum height of editor
            maxHeight: 400, // set maximum height of editor
            focus: true // set focus to editable area after initializing summernote
        });

        // End
    });

    formSuccess = function(responseText, statusText, xhr, $form) {
        Swal.fire("Congratulations!", responseText.message, "success");
    };

    formError = function(xhr, status, error, $form) {

        var obj = JSON.parse(xhr.responseText);
        //Swal.fire({
        //  title: "Errors!",
        // text: obj.message,
        // icon: "error"
        //});

        Swal.fire("Errors!", obj.message, "error");

        // removeLoadingButton($form.find("button[type=submit]"));

        $.each(obj.errors, function(key, error) {
            if (document.getElementById(key)) {
                if ($form.find(":input[id=" + key + "]")) {
                    displayErrorMessage($form.find(":input[id=" + key + "]"), error[0]);
                } else if ($form.find(":select[id=" + key + "]")) {
                    displayErrorMessage($form.find(":select[id=" + key + "]"), error[0]);
                } else if ($form.find(":textarea[id=" + key + "]")) {
                    displayErrorMessage($form.find(":textarea[id=" + key + "]"), error[0]);
                }
            } else {
                if ($form.find(":input[name=" + key + "]")) {
                    displayErrorMessage($form.find(":input[name=" + key + "]"), error[0]);
                } else if ($form.find(":select[name=" + key + "]")) {
                    displayErrorMessage($form.find(":select[name=" + key + "]"), error[0]);
                } else if ($form.find(":textarea[name=" + key + "]")) {
                    displayErrorMessage($form.find(":textarea[name=" + key + "]"), error[
                        0]);
                }
            }
        });
    };

    displayErrorMessage = function(element, message) {
        element.addClass('form-control-danger').removeClass('form-control-success');
        if (typeof message !== "undefined") {
            element.after(
                $("<div class='form-control-feedback'>" + message + "</div>")
            );
        }
    };
    </script>

    {{-- Page Custom Script  --}}
    @stack('script')

</body>

</html>