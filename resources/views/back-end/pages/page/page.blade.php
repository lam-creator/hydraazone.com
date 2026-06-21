@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Page List')
@section('content')

    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h5 class="p-2 mb-0 mr-auto box-title">Page</h5>
                        <button type="button" class="btn btn-primary btn-sm DataAddButton">Add Page</button>
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

    <div class="modal fade" id="DataAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="DataAddUpdate" action="{{ route('admin.page.insert') }}" method="post" enctype="multipart/form-data">
                @csrf
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
                                        <div class="mb-4 form-group">
                                            <label for="title">Page Name</label>
                                            <input class="form-control" type="text" name="title"
                                                placeholder="Page Name" required>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="location">Showing Location <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="location" required>
                                                <option value="" selected>Select location</option>
                                                <option value="footer_1">Quick Links</option>
                                                <option value="footer_2">Customer Service</option>
                                                <option value="menu">Top Menu</option>
                                            </select>
                                            @error('location')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
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

                                <div class="raw">
                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="content">Page Content</label>
                                            <textarea class="page_content form-control" name="content" placeholder="Page Content"></textarea>
                                            @error('content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control"
                                                placeholder="SEO Title">
                                            @error('meta_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-4 form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" name="meta_keywords" class="form-control"
                                                placeholder="SEO keywords - use , for multiple">
                                            @error('meta_keywords')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4 form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" rows="4" placeholder="Product SEO Description"></textarea>
                                            @error('meta_description')
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

            // Summernote
            $('.page_content').summernote({
                height: 400, // set editor height
                minHeight: 100, // set minimum height of editor
                maxHeight: 400, // set maximum height of editor
                // focus: true // set focus to editable area after initializing summernote
            });

            $(document).on('click', '.DataAddButton', function() {
                $('#hidden-id').attr("disabled", "true");
                $('.modal-title').text('Add Page');
                // Reset the Summernote editor content
                $('textarea[name="content"]').summernote('code', '');
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



            // $('#dt-scroll-horizonal').DataTable({
            //     processing: true,
            //     responsive: true,
            //     serverSide: true,
            //     destroy: true,
            //     scrollX: true,
            //     ajax: {
            //         url: "{{ route('admin.page.data') }}", // URL will change
            //         type: 'GET',
            //         cache: false,
            //         data: function(d) {}
            //     },
            //     columns: [ // All columns will change
            //         {
            //             title: 'SL',
            //             data: 'id',
            //             name: 'id'
            //         },
            //         {
            //             title: 'Page Name',
            //             data: 'title',
            //             name: 'title'
            //         },
            //         {
            //             title: 'Location',
            //             data: 'location',
            //             name: 'location'
            //         },
            //         {
            //             title: 'Status',
            //             data: 'status',
            //             name: 'status'
            //         },
            //         {
            //             title: 'Action',
            //             data: 'action',
            //             name: 'action'
            //         }
            //     ],
            // });




            $('#dt-scroll-horizonal').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('admin.page.data') }}",
                    type: 'GET',
                    cache: false,
                    data: function(d) {}
                },
                columns: [{
                        title: 'SL',
                        data: 'id',
                        name: 'id'
                    },
                    {
                        title: 'Page Name',
                        data: 'title',
                        name: 'title'
                    },
                    {
                        title: 'Location',
                        data: 'location',
                        name: 'location'
                    },
                    {
                        title: 'Status',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        title: 'Action',
                        data: 'action',
                        name: 'action'
                    }
                ],
                dom: 'Bfrtip', // Enable buttons
                buttons: [{
                        extend: 'colvis', // Add column visibility button
                        text: 'Select Columns'
                    },
                    {
                        extend: 'print',
                        text: 'Print Selected',
                        title: 'Page Data', // Customize title
                        exportOptions: {
                            columns: ':visible' // Only include visible columns in the print
                        }
                    }
                ]
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
                            },
                            method: 'POST',
                            dataType: 'json',
                            url: "{{ route('admin.page.insert') }}" // URL will change
                                ,
                            success: function(responseText) {
                                // formSuccess(responseText, statusText, xhr, $form);
                                Swal.fire("Congratulations!", responseText.message,
                                    "success");
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
                $('.modal-title').text('Update Page');
                $('#hidden-id').removeAttr("disabled");
                $('#hidden-id').val(Id);
                $(this).ajaxSubmit({
                    data: {
                        "id": Id
                    },
                    dataType: 'json',
                    method: 'GET',
                    url: "{{ route('admin.page.edit') }}" // URL will change
                        ,
                    success: function(responseText) {
                        $('input[name^="title"]').val(responseText.data.title);
                        $(".page_content").summernote('code', responseText.data.content);
                        $('select[name^="location"]').val(responseText.data.location);
                        $('select[name^="status"]').val(responseText.data.status);
                        $('input[name^="meta_title"]').val(responseText.data.meta_title);
                        $('input[name^="meta_keywords"]').val(responseText.data.meta_keywords);
                        $('textarea[name^="meta_description"]').val(responseText.data
                            .meta_description);
                        $("#DataAdd").modal('show');
                    }
                });
            });

        });
    </script>
@endpush
