@extends('front-end.layouts.master')

@section('content')

<section class="container mt-4 mb-5">
    <div class="row">

        <div class="col-lg-6 offset-lg-3">
            <div class="shadow-sm p-4 login-card">
                <h3 class="mb-4 text-center">Login</h3>
                <hr>
                <form id="loginForm" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="phone" class="form-label">Your Phone Number</label>
                        <input type="phone" class="form-control" name="phone" placeholder="Ex: 015...." required>
                        @error('phone')
                        <div style="color: red">{{ $message }}</div><br>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password"
                            required>
                        @error('password')
                        <div style="color: red">{{ $message }}</div><br>
                        @enderror
                    </div>
                    <p class="text-center">forgot password? <a href="{{ route('user.password.request') }}"
                            class="text-decoration-none">Reset</a>
                    </p>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="mt-3 text-center">
                        <p>Don't have an account? <a href="{{ route('user.register') }}"
                                class="text-decoration-none">Register Now</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection

{{-- push custom js before end of body tag --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if (session('message'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '{{ session('
        message ') }}',
        icon: '{{ session('
        alert - type ') }}', // 'error', 'success', 'warning', 'info'
        // confirmButtonText: 'OK',
        timer: 3000, // Auto close after 5 seconds
        timerProgressBar: true,
    });

    toastr.error('{{ session('
        message ') }}');
});
</script>
@endif

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
        url: "{{ route('user.login_process') }}",
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
            let errorMessages = ''; // Initialize an empty string to collect errors

            // Collect all error messages
            for (let key in errors) {
                errorMessages += errors[key][0] + '<br>';
            }

            // Show all error messages at once
            Swal.fire({
                toast: false, // Not a toast, we want to show a dialog
                position: 'center',
                icon: 'error',
                title: 'Validation Errors',
                html: errorMessages, // Display all errors
                showConfirmButton: true,
                timerProgressBar: false
            });
            // alert(errors[key][0]); // Replace with a nicer error handling approach
        }
    });
});
</script>
@endpush
