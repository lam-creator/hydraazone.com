@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All State List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">State</h5>
                    <button type="button" class="btn btn-primary btn-sm DataAddButton">Add State</button>
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
        <form id="DataAddUpdate" action="{{ route('admin.district.insert') }}" method="post" enctype="multipart/form-data">
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
                                        <label for="exampleInputStatus">Country<span class="text-danger">*</span></label>
                                        <select class="form-control" name="country_id" required>
                                            <option value="" selected>Select Country</option>
                                            @foreach($CountryLists as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputName">State Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="District Name" required>
                                        @error('name')
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
                    <button class="btn btn-primary" type="submit">Submit</button>
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
        $('.modal-title').text('Add State');
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
            url: "{{ route('admin.district.data') }}",  // URL will change
            type: 'GET',
            cache: false,
            data: function(d) {
            }
        },
        columns: [      // All columns will change
            {title: 'SL', data: 'id', name: 'id'},
            {title: 'Name', data: 'name', name: 'name'},
            {title: 'Slug', data: 'district_slug', name: 'district_slug'},
            {title: 'Country', data: 'country_id', name: 'country_id'},
            {title: 'Status', data: 'status', name: 'status'},
            {title: 'Created By', data: 'user_id', name: 'user_id'}, // Note the 'user_id' data key
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
                    , url: "{{ route('admin.district.insert') }}"   // URL will change
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
        $('.modal-title').text('Update State');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            }
            , dataType: 'json'
            , method: 'GET'
            , url: "{{ route('admin.district.edit') }}"   // URL will change
            , success: function(responseText) {
                $('input[name^="name"]').val(responseText.data.name);
                $('select[name^="country_id"]').val(responseText.data.country_id);
                $('select[name^="status"]').val(responseText.data.status);
                $("#DataAdd").modal('show');
            }
        });
    });


    });

</script>

@endpush


