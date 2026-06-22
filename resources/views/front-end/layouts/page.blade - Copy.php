@extends('front-end.layouts.master')

@section('seo')

<title>{{ $PageData->title }}</title>
<meta name="description" content="{{ $PageData->meta_description }}" />
<meta name="keywords" content="{{ $PageData->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="{{ $PageData->meta_title }}">
<meta property="og:description" content="{{ $PageData->meta_description }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $PageData->meta_title }}",
    "description": "{{ $PageData->meta_description }}"
}
</script>
@endsection

@section('content')

<!-- contact Section -->
<section class="container mt-4 mb-5">
    <div class="row">

                <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $PageData->title }}</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->


        <div class="col-md-12">
            <h1 class="text-center mb-4">{{ $PageData->title }}</h1>
            <div class="page-content">
                {!! $PageData->content !!}
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
        timer: 3000, // Auto close after 3 seconds
        timerProgressBar: true,
    });

    toastr.success('{{ session('
        message ') }}');
});
</script>
@endif


@endpush
