<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/back-end/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/back-end/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="/back-end/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Admin</b> Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Login in to enter your Dashboard</p>

      <form id="loginForm" method="post">
        @csrf

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
            @error('email')
                <div style="color: red">{{ $message }}</div><br>
            @enderror
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
            @error('password')
                <div style="color: red">{{ $message }}</div><br>
            @enderror
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      {{-- <p class="mb-1"><a href="{{ route('admin.forgot-password') }}">I forgot my password</a></p> --}}

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- js -->
<script src="/back-end/plugins/jquery/jquery.min.js"></script>
<script src="/back-end/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/back-end/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/back-end/dist/js/adminlte.min.js"></script>

<script>
    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault();

        // CSRF token for Laravel AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            url: "{{ route('adminuser.login-process') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = response.redirect_url;
                } else if (response.status === 'error') {
                    $('#loginForm')[0].reset();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: response.status,
                        title: response.message,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000
                    });
                    // alert(response.message); // Replace with a nicer error handling approach
                }
            },
            error: function(xhr) {
                // Handle validation errors
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: errors[key][0],
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000
                    });
                    // alert(errors[key][0]); // Replace with a nicer error handling approach
                }
            }
        });
    });
</script>


</body>
</html>
