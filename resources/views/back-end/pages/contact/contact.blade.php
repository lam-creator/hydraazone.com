@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All contact messages')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="p-2 mb-0 mr-auto box-title">All contact messages</h5>
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



<!-- Order Details Modal -->
<div class="modal fade" id="DataAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Messages Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Contact ID</th>
                        <td id="contact_id"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="contact_name"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="contact_phone"></td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td id="contact_subject"></td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td id="contact_message"></td>
                    </tr>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

            </div>
        </div>

    </div>
</div>


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
            url: "{{ route('admin.contact.data') }}", // URL will change
            type: 'GET',
            cache: false,
            data: function(d) {}
        },
        columns: [ // All columns will change
            {
                title: 'ID',
                data: 'id',
                name: 'id'
            },
            {
                title: 'Name',
                data: 'name',
                name: 'name'
            },
            {
                title: 'Phone',
                data: 'phone',
                name: 'phone'
            },
            {
                title: 'Subject',
                data: 'subject',
                name: 'subject'
            },
            {
                title: 'Action',
                data: 'action',
                name: 'action'
            }
        ],
    });


    $(document).on('click', '.tableDetails', function() {
        let Id = $(this).data('id');

        $('.modal-title').text('Message Details');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            },
            dataType: 'json',
            method: 'GET',
            url: "{{ route('admin.contact.details') }}" // URL will change
                ,
            success: function(responseText) {

                let order = responseText.data;

                $('#contact_id').text(order.id);
                $('#contact_name').text(order.name);
                $('#contact_phone').text(order.phone);
                $('#contact_subject').text(order.subject);
                $('#contact_message').text(order.message);

                $("#DataAdd").modal('show');
            }
        });
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
                    url: "{{ route('admin.contact.delete') }}" // URL will change
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



});
</script>
@endpush