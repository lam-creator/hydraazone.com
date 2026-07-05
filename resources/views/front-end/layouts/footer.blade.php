@php
$footerdata = App\Models\WebsiteSettings::first();
@endphp

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row mb-5 g-4">
                <!-- Brand Info -->
                <div class="col-lg-3 col-md-6 text-center text-md-start">

                    {{-- if logo is null show company_name else show logo--}}
                    @if ($footerdata->logo == null)
                        <a href="{{ route('home') }}">
                            <h2 class="serif-font fw-bold mb-3">{{ $footerdata->company_name }}</h2>
                        </a>
                    @else
                        <a href="{{ route('home') }}">
                            <img src="/uploads/logo/{{ $footerdata->logo }}" alt="{{ $footerdata->company_name }}" class="serif-font fw-bold mb-3">
                        </a>
                    @endif

                    <p class="font-12 text-muted mb-4">{{ $footerdata->company_slogan }}</p>


                    <div class="social-icons justify-content-center justify-content-md-start d-flex">
                        <a href="{{ $footerdata->facebook_url }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $footerdata->instagram_url }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ $footerdata->youtube_url }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                        <a href="{{ $footerdata->twitter_url }}" target="_blank"><i class="fa-brands fa-x"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-heading">Quick Links</div>
                    <ul class="footer-links">
                        @php
                            $QuickLinks = App\Models\Page::where('location', 'footer_1')->get();
                            $Footer1Links = App\Models\Link::where('location', 'footer_1')->get();
                        @endphp

                        @foreach ($Footer1Links as $footer1link)
                            <li>
                                <a class="text-decoration-none" href="{{ $footer1link->link }}" target="_blank">{{ $footer1link->title }}</a>
                            </li>
                        @endforeach

                        @foreach ($QuickLinks as $quicklink)
                            <li>
                                <a class="text-decoration-none" href="{{ URL::to('/page') }}/{{ $quicklink->slug }}/{{ $quicklink->id }}">{{ $quicklink->title }}</a>
                            </li>
                        @endforeach


                    </ul>
                </div>

                <!-- Customer Service Links -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-heading">Customer Service</div>
                    <ul class="footer-links">
                        @php
                            $CustomerServices = App\Models\Page::where('location', 'footer_2')->get();

                            $Footer2Links = App\Models\Link::where('location', 'footer_2')->get();
                        @endphp

                        @foreach ($Footer2Links as $footer2link)
                            <li>
                                <a class="text-decoration-none" href="{{ $footer2link->link }}" target="_blank">{{ $footer2link->title }}</a>
                            </li>
                        @endforeach

                        @foreach ($CustomerServices as $customerservice)
                            <li>
                                <a class="text-decoration-none" href="{{ URL::to('/page') }}/{{ $customerservice->slug }}/{{ $customerservice->id }}">{{ $customerservice->title }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-heading">Contact Us</div>
                    <ul class="footer-links">
                        <li class="d-flex gap-2"><i class="fa-solid fa-phone mt-1"></i>{{ $footerdata->support_phone }}</li>
                        <li class="d-flex gap-2"><i class="fa-solid fa-envelope mt-1"></i> {{ $footerdata->email }}</li>
                        <li class="d-flex gap-2"><i class="fa-solid fa-location-dot mt-1"></i> {{ $footerdata->company_address }}</li>
                    </ul>
                </div>
            </div>

            <div class="d-flex flex-column justify-content-between align-items-center text-center text-md-start pt-4 border-top">
                <p class="font-12 text-center text-muted mb-0">&copy; {!! $footerdata->copyright !!}. Developed by <a href="tel:+8801738225977">Nazmul</a></p>
            </div>
        </div>
    </footer>

    <!-- Sticky cart Start -->
    @include('front-end.layouts.sticky-cart')
    <!-- Sticky cart End -->



    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
