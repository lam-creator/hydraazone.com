<!-- Footer Section -->
@php
$footerdata = App\Models\WebsiteSettings::first();
@endphp

<footer class="py-4 text-white bg-dark">
    <div class="container">
        <!-- Footer Top with Logo and Contact Info -->
        <div class="mb-4 row">
            <div class="col-md-4">
                <div class="mb-3 d-flex my-align-items-center">
                    <a href="{{ route('home') }}"><img src="/uploads/logo/{{ $footerdata->logo }}"
                            alt="{{ $footerdata->company_name }}" class="footer-logo me-2" width="120"></a>
                </div>
                <p class="mb-3 small text-center">{{ $footerdata->company_slogan }}</p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3 text-white">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fa fa-phone me-2"></i>
                        <span>{{ $footerdata->phone }}</span>
                    </li>
                    <li class="mb-2">
                        <i class="fa fa-phone me-2"></i>
                        <span>{{ $footerdata->support_phone }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3 text-white">Important Links</h5>
                <!-- <h6 class="mb-2 text-white">Important Links</h6> -->
                <ul class="list-unstyled">

                    @php
                        $UsefulLinks = App\Models\Page::where('location', 'footer')->get();
                    @endphp

                    @foreach ($UsefulLinks as $usefullink)
                        <li>
                            <a class="text-white text-decoration-none" href="{{ URL::to('/page') }}/{{ $usefullink->slug }}/{{ $usefullink->id }}">{{ $usefullink->title }}</a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-3 row">
            <div class="text-center col-12 small">
                <p class="mb-0">{!! $footerdata->copyright !!}. Developed by <a href="tel:+8801738225977" class="text-white">Nazmul</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Sticky cart Start -->
@include('front-end.layouts.sticky-cart')
<!-- Sticky cart End -->


<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="/front-end/js/bootstrap.bundle.min.js"></script>
<script src="/back-end/plugins/sweetalert2/sweetalert2.all.min.js"></script>
@stack('scripts')

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
</script>

</body>

</html>
