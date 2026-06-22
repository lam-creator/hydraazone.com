@extends('front-end.layouts.master')

@section('content')

<section class="container mt-4 mb-5">
    <div class="row">

        <div class="col-lg-6 offset-lg-3">
            <div class="shadow-sm p-4 login-card">
                <h3 class="mb-4 text-center">Reset Password</h3>
                <hr>
                <form method="POST" action="{{ route('user.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        @error('email')
                        <div style="color: red">{{ $message }}</div><br>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter new password"
                            required>
                        @error('password')
                        <div style="color: red">{{ $message }}</div><br>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Retype new password" required>
                        @error('password_confirmation')
                        <div style="color: red">{{ $message }}</div><br>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>

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

@endpush
