@extends('front-end.layouts.master')

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
                        <h2 class="pt-2 pb-2 mb-0 h5">Personal Information</h2>
                    </div>
                    <div class="p-4 card-body">

                        <form action="{{ route('user.update-profile', $User->id) }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                    placeholder="Enter Your Name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="{{ Auth::user()->email }}"
                                    placeholder="Enter Your Email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                {{-- disabled phone --}}
                                <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}"
                                    placeholder="Enter Your Phone" class="form-control" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="phone">Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5"
                                    placeholder="Enter Your Address">{{ Auth::user()->address }}</textarea>
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary btn-color-orange">Update</button>
                            </div>
                        </form>

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
                    title: '{{ session('message') }}',
                    icon: '{{ session('alert-type') }}', // 'error', 'success', 'warning', 'info'
                    // confirmButtonText: 'OK',
                    timer: 3000, // Auto close after 5 seconds
                    timerProgressBar: true,
                });

                toastr.success('{{ session('message') }}');
            });
        </script>
    @endif


@endpush
