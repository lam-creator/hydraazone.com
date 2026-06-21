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

<!-- Products Section 1 -->
<section class="container mt-4 mb-5">
    <div class="row">

        <div class="col-md-3">
            <!-- user menu Section Start -->
            @include('front-end.layouts.account-panel')
            <!-- user menu Section End -->
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-2 pb-2 mb-0 h5">Your Orders</h2>
                </div>
                <div class="p-4 card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Orders #</th>
                                    <th>Date Purchased</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>You have not placed any orders yet.</p>
                                    </td>
                                </tr>
                                @else
                                @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('user.order-details', $order->id) }}"
                                            class="text-success">ORD-{{ $order->id }}</a>
                                    </td>

                                    <td>{{ $order->created_at->format('M d, Y') }}</td>

                                    <td>
                                        @php
                                        $statusClasses = [
                                        'processing' => 'bg-warning',
                                        'approved' => 'approved-order',
                                        'delivered' => 'delivered-order',
                                        'cancelled' => 'cancelled-order',
                                        ];
                                        @endphp
                                        <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>

                                    <td>
                                        Tk {{ number_format($order->total_amount, 2) }}
                                    </td>

                                    <td>
                                        @if ($order->status == 'cancelled')
                                        <b style="color:#f26419">Order Cancelled</b>
                                        @elseif ($order->status == 'delivered')
                                        <b style="color:green">Completed</b>
                                        @elseif ($order->status == 'approved')
                                        <b>Approved</b>
                                        @else
                                        <form action="{{ route('user.order-cancel', $order->id) }}" method="post">
                                            @csrf

                                            <button
                                                onClick="return confirm('Are you sure you want to Cancel your order?')"
                                                type="submit" class="btn btn-sm btn-danger user-order-cancel">Cancel
                                                Order </button>
                                        </form>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
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

    toastr.success('{{ session('
        message ') }}');
});
</script>
@endif


@endpush
