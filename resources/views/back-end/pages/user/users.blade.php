@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Admin List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">All Customer List</h5>
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


@endsection

<!-- Page specific script -->

@push('script')
<script>
    $(function() {

    
    $('#dt-scroll-horizonal').DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
            url: "{{ route('admin.customer.data') }}",
            type: 'GET',
            cache: false,
            data: function(d) {
            }
        },
        columns: [
            {title: 'Name', data: 'name', name: 'name'},
            {title: 'Phone', data: 'phone', name: 'phone'},
            {title: 'Address', data: 'address', name: 'address'},
            {title: 'Created', data: 'created_at', name: 'created_at'},
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


