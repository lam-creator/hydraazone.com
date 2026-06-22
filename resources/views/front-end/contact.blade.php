@extends('front-end.layouts.master')

@section('seo')
@php
    $WebsiteSettingData = App\Models\WebsiteSettings::first();
@endphp
<title>Contact - {{ $WebsiteSettingData->meta_title }} | {{ $WebsiteSettingData->company_name }}</title>
<meta name="description" content="Contact - {{ $WebsiteSettingData->meta_description }}" />
<meta name="keywords" content="contact, contact us, {{ $WebsiteSettingData->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="Contact - {{ $WebsiteSettingData->meta_title }}">
<meta property="og:description" content="Contact - {{ $WebsiteSettingData->meta_description }}">
    <meta property="og:image" content="{{ asset('uploads/logo/' . $WebsiteSettingData->logo) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Contact - {{ $WebsiteSettingData->meta_title }}",
    "description": "Contact - {{ $WebsiteSettingData->meta_description }}"
}
</script>
@endsection

@section('content')

<!-- contact Section -->
<section class="container mt-4 mb-5">
    <div class="row">
        <div class="mt-5 mb-4 section-title ">
            <h2 class="text-center">Love to Hear From You</h2>
        </div>

        @php
        $contactdata = App\Models\WebsiteSettings::first();
        @endphp
        <div class="mt-3 col-md-6 pe-lg-5">
            <p>Fell free to contact us any open time. You can also send us message using form in right side</p>
            <address>
                {{ $contactdata->company_name }} <br>
                {{ $contactdata->company_address }}<br>
                <a href="tel:{{ $contactdata->phone }}">{{ $contactdata->phone }}</a><br>
                <a href="mailto:{{ $contactdata->email }}">{{ $contactdata->email }}</a>
            </address>
        </div>

        <div class="col-md-6">
            <form class="shake" role="form" method="post" id="contactForm">
                @csrf
                <div class="mb-3">
                    <label class="mb-2" for="name">Name</label>
                    <input class="form-control" id="name" type="text" name="name" required data-error="Your name">
                    <!-- <div class="help-block with-errors"></div> -->
                    @error('name')
                    <div style="color: red">{{ $name }}</div><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="mb-2" for="phone">Phone</label>
                    <input class="form-control" id="phone" type="phone" name="phone" required
                        data-error="Your phone number">
                    @error('phone')
                    <div style="color: red">{{ $phone }}</div><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="mb-2">Subject</label>
                    <input class="form-control" id="msg_subject" type="text" name="subject" required
                        data-error="Your message subject">
                    @error('subject')
                    <div style="color: red">{{ $subject }}</div><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="mb-2">Message</label>
                    <textarea class="form-control" rows="3" id="message" name="message" required
                        data-error="Write your message"></textarea>
                    @error('message')
                    <div style="color: red">{{ $message }}</div><br>
                    @enderror
                </div>

                <div class="form-submit">
                    <button class="btn btn-theme" type="submit" id="form-submit"><i
                            class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                    <div id="msgSubmit" class="hidden text-center h3"></div>
                    <div class="clearfix"></div>
                </div>
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
        timer: 3000, // Auto close after 3 seconds
        timerProgressBar: true,
    });

    toastr.success('{{ session('
        message ') }}');
});
</script>
@endif

<script>
$(document).on('submit', '#contactForm', function(e) {
    e.preventDefault();

    // CSRF token for Laravel AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        url: "{{ route('contact.process') }}",
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.status === 'success') {
                $('#contactForm')[0].reset();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.status,
                    title: response.message,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3000
                });
            } else if (response.status === 'error') {
                // Handle error response
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
