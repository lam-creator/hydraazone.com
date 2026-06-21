@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Coupon List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">Coupon</h5>
                    @if(Auth::guard('admin')->user()->can('coupon.create'))
                    <button type="button" class="btn btn-primary btn-sm DataAddButton">Add Coupon</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->

<div class="modal fade" id="DataAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="DataAddUpdate" action="{{ route('admin.coupon.insert') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="hidden-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Add/Update</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">


                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="code" id="code" placeholder="Enter coupon code (e.g., SUMMER2024)">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="discount">Discount Amount (Taka) <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="discount" id="discount" placeholder="Enter discount amount" min="1">
                                        @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="usage_limit">Usage Limit</label>
                                        <input class="form-control" type="number" name="usage_limit" id="usage_limit" placeholder="Leave empty for unlimited" min="1">
                                        <small class="text-muted">Maximum number of times this coupon can be used</small>
                                        @error('usage_limit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="expires_at">Expiration Date & Time</label>
                                        <input class="form-control" type="date" name="expires_at" id="expires_at">
                                        @error('expires_at')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputStatus">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="" selected>Select status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    @if(Auth::guard('admin')->user()->can('coupon.create') || Auth::guard('admin')->user()->can('coupon.edit'))
                        <button class="btn btn-primary" type="submit">Submit</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

<!-- Page specific script -->

@push('script')
<script>
    $(function() {

    $(document).on('click', '.DataAddButton', function() {
        $('#hidden-id').attr("disabled", "true");
        $('.modal-title').text('Add Coupon');
        $("#DataAdd").modal('show');
    });

    $('#DataAddUpdate').ajaxForm({
        error: formError,
        success: function(responseText, statusText, xhr, $form) {
            formSuccess(responseText, statusText, xhr, $form);
            $('#dt-scroll-horizonal').DataTable().draw(true);
            $("#DataAdd").modal('hide');
            $('#hidden-id').prop("disabled", false);
        },
        clearForm: true,
        resetForm: true
    });

    $('#dt-scroll-horizonal').DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
            url: "{{ route('admin.coupon.data') }}",  // URL will change
            type: 'GET',
            cache: false,
            data: function(d) {
            }
        },
        columns: [      // All columns will change
            {title: 'SL', data: 'id', name: 'id'},
            {title: 'Code', data: 'code', name: 'code'},
            {title: 'Discount (Taka)', data: 'discount', name: 'discount'},
            {title: 'Status', data: 'status', name: 'status'},
            {title: 'Usage Limit', data: 'usage', name: 'usage_limit', orderable: false},
            {title: 'Expires At', data: 'expires_at', name: 'expires_at'},
            {title: 'Action', data: 'action', name: 'action'}
        ],
    });

    $(document).on('click', '.tableDelete', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                let Id = $(this).data('id');
                $(this).ajaxSubmit({
                    data: {
                        "delete": Id
                    }
                    , method: 'POST'
                    , dataType: 'json'
                    , url: "{{ route('admin.coupon.insert') }}"   // URL will change
                    , success: function(responseText) {
                        // formSuccess(responseText, statusText, xhr, $form);
                        Swal.fire("Congratulations!", responseText.message, "success");
                        $('#dt-scroll-horizonal').DataTable().draw(true);
                    }
                });
                // Swal.fire("Congratulations!", responseText.message, "success");
            } else {
                Swal.fire("Congratulations!", "Your data is safe!", "success");
            }
        });

    });

    $('#DataAdd').on('hidden.bs.modal', function() {
        $("#DataAddUpdate").trigger("reset");
    });


    $(document).on('click', '.tableEdit', function() {
        let Id = $(this).data('id');
        $('.modal-title').text('Update Coupon');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            }
            , dataType: 'json'
            , method: 'GET'
            , url: "{{ route('admin.coupon.edit') }}"   // URL will change
            , success: function(responseText) {
                $('input[name^="code"]').val(responseText.data.code);
                $('input[name^="discount"]').val(responseText.data.discount);
                $('input[name^="usage_limit"]').val(responseText.data.usage_limit);
                // $('input[name^="expires_at"]').val(responseText.data.expires_at);
                    if (responseText.data.expires_at) {
                        let expiresAt = new Date(responseText.data.expires_at);
                        let year = expiresAt.getFullYear();
                        let month = String(expiresAt.getMonth() + 1).padStart(2, '0');
                        let day = String(expiresAt.getDate()).padStart(2, '0');
                        let formattedDate = `${year}-${month}-${day}`;
                        $('input[name^="expires_at"]').val(formattedDate);
                    } else {
                        $('input[name^="expires_at"]').val('');
                    }
                $('select[name^="status"]').val(responseText.data.status);
                $("#DataAdd").modal('show');
            }
        });
    });


    // Toggle Status functionality
        $(document).on('click', '.tableToggleStatus', function() {
            let Id = $(this).data('id');
            Swal.fire({
                title: 'Coupon Status Change',
                text: "Do you want to change the status of this coupon?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.coupon.toggle-status') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: Id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Success!", response.message, "success");
                                $('#dt-scroll-horizonal').DataTable().draw(true);
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });


    });

</script>

@endpush


