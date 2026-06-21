@extends('front-end.layouts.master')

{{-- @section('seo')
    @php
        $WebsiteSettingData = App\Models\WebsiteSettings::first();
    @endphp
    <title>{{ $product->meta_title }} | {{ $WebsiteSettingData->company_name }}</title>
<meta name="description" content="{{ $product->meta_description }}" />
<meta name="keywords" content="{{ $product->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="{{ $product->meta_title }}">
<meta property="og:description" content="{{ $product->meta_description }}">
<meta property="og:image" content="{{ asset('uploads/product/' . $product->image) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $product->meta_title }}",
    "description": "{{ $product->meta_description }}"
}
</script>
@endsection --}}

@section('content')

<section class="container mt-4 mb-5">
    <div class="row">

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="shadow-sm login-card">
            <h3 class="mb-4 text-center">Forgot Password</h3>
            <hr>
            <form method="POST" action="{{ route('user.password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    @error('email')
                    <div style="color: red">{{ $message }}</div><br>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
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