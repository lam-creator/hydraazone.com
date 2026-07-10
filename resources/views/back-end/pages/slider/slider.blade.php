@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Slider List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">Slider</h5>
                    <button type="button" class="btn btn-primary btn-sm DataAddButton">Add Slider</button>
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
        <form id="DataAddUpdate" action="{{ route('admin.slider.insert') }}" method="post" enctype="multipart/form-data">
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
                                        <label for="exampleInputTitle">Slider Title</label>
                                        <input class="form-control" type="text" name="title" placeholder="Slider title">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputSlogan">Slider Slogan</label>
                                        <input class="form-control" type="text" name="slogan" placeholder="Slider slogan">
                                        @error('slogan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputButtonText">Slider Button Text</label>
                                        <input class="form-control" type="text" name="button_text" placeholder="Slider button text">
                                        @error('button_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputLink">Slider Link</label>
                                        <input class="form-control" type="text" name="link" placeholder="Slider link">
                                        @error('link')
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

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputImage">Image <span class="text-danger">* Image size need to be 1300x400</span></label>
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
        $('.modal-title').text('Add Slider');
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
            url: "{{ route('admin.slider.data') }}", // URL will change
            type: 'GET',
            cache: false,
            data: function(d) {
            }
        },
        columns: [      // All columns will change
            {title: 'SL', data: 'id', name: 'id'},
            {title: 'Title', data: 'title', name: 'title'},
            {title: 'Image', data: 'image', name: 'image'},
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
                    , url: "{{ route('admin.slider.insert') }}"  // URL will change
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
        $('.modal-title').text('Update Slider');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            }
            , dataType: 'json'
            , method: 'GET'
            , url: "{{ route('admin.slider.edit') }}" // URL will change
            , success: function(responseText) {
                $('input[name^="title"]').val(responseText.data.title);
                $('input[name^="slogan"]').val(responseText.data.slogan);
                $('input[name^="button_text"]').val(responseText.data.button_text);
                $('input[name^="link"]').val(responseText.data.link);
                $('select[name^="status"]').val(responseText.data.status);
                $("#DataAdd").modal('show');
            }
        });
    });



    });

</script>

@endpush


