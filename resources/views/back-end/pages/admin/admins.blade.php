@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Admin List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">Admin</h5>
                    <button type="button" class="btn btn-primary btn-sm DataAddButton">Add Admin</button>
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
        <form id="DataAddUpdate" action="{{ route('admin.admin.insert') }}" method="post" enctype="multipart/form-data">
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
                                        <label for="exampleInputName">Admin Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="Admin Name">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputUserName">User Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="username" placeholder="User Name">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputEmail">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputPassword">Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputStatus">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status">
                                            <option value="" selected>Select status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputImage">Image <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="image">
                                        @error('image')
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
        $('.modal-title').text('Add Admin');
        $("#DataAdd").modal('show');
    });

    $('#DataAddUpdate').ajaxForm({
        error: formError,
        success: function(responseText, statusText, xhr, $form) {
            formSuccess(responseText, statusText, xhr, $form);
            $('#dt-scroll-horizonal').DataTable().draw(true);
            $("#DataAdd").modal('hide');
            $('#hidden-id').prop("disabled", false); // Changed to correct method
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
            url: "{{ route('admin.admin.data') }}",
            type: 'GET',
            cache: false,
            data: function(d) {
            }
        },
        columns: [
            {title: 'SL', data: 'id', name: 'id'},
            {title: 'Name', data: 'name', name: 'name'},
            {title: 'Email', data: 'email', name: 'email'},
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
                    , url: "{{ route('admin.admin.insert') }}"
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
        $('.modal-title').text('Update Admin');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            }
            , dataType: 'json'
            , method: 'GET'
            , url: "{{ route('admin.admin.edit') }}"
            , success: function(responseText) {
                $('input[name^="name"]').val(responseText.data.name);
                $('input[name^="username"]').val(responseText.data.username);
                $('input[name^="email"]').val(responseText.data.email);
                $('input[name^="password"]').val(responseText.data.password);
                $('select[name^="status"]').val(responseText.data.status);
                $("#DataAdd").modal('show');
            }
        });
    });



    });

</script>

@endpush


