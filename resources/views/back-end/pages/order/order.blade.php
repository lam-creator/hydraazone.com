@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Processing Order')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="p-2 mb-0 mr-auto box-title">All Processing Order</h5>
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
                <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Order ID</th>
                        <td id="order_id"></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td id="order_date"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="order_name"></td>
                    </tr>
                    <tr>
                        <th>Zone</th>
                        <td id="order_zone"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="order_address"></td>
                    </tr>

                    <tr>
                        <th>Mobile</th>
                        <td id="order_mobile"></td>
                    </tr>
                    <tr>
                        <th>Delivery Charge</th>
                        <td id="delivery_charge"></td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td id="order_discount"></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td id="order_total_amount"></td>
                    </tr>
                    <tr>
                        <th>Order Note</th>
                        <td id="order_note"></td>
                    </tr>

                </table>

                <h5>Order Items</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Variant</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody id="order_items">
                        <!-- Order Items Will Be Injected Here -->
                    </tbody>
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
            url: "{{ route('admin.processing.orders.data') }}", // URL will change
            type: 'GET',
            cache: false,
            data: function(d) {}
        },
        columns: [ // All columns will change
            {
                title: 'Order ID',
                data: 'id',
                name: 'id'
            },
            {
                title: 'Name',
                data: 'name',
                name: 'name'
            },
            {
                title: 'Total Price',
                data: 'total_amount',
                name: 'total_amount'
            },
            {
                title: 'Discount',
                data: 'discount_amount',
                name: 'discount_amount'
            },
            {
                title: 'Zone',
                data: 'zone',
                name: 'zone'
            },
            {
                title: 'Date',
                data: 'date',
                name: 'date'
            },
            {
                title: 'Mobile',
                data: 'mobile',
                name: 'mobile'
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

        $('.modal-title').text('Order Details');
        $('#hidden-id').removeAttr("disabled");
        $('#hidden-id').val(Id);
        $(this).ajaxSubmit({
            data: {
                "id": Id
            },
            dataType: 'json',
            method: 'GET',
            url: "{{ route('admin.orders.details') }}" // URL will change
                ,
            success: function(responseText) {

                let order = responseText.data;

                $('#order_id').text(order.id);
                $('#order_name').text(order.name);
                $('#order_zone').text(order.city ? order.city.name : 'N/A');
                $('#order_address').text(order.address);
                $('#delivery_charge').text(order.shipping + ' Taka');
                $('#order_discount').text(order.discount_amount + ' Taka');
                $('#order_total_amount').text(order.total_amount + ' Taka');
                $('#order_note').text(order.order_note);
                $('#order_mobile').text(order.mobile);
                $('#order_date').text(order.date);

                // Populate Order Items
                let itemsHtml = '';
                order.items.forEach((item, index) => {
                    itemsHtml += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.product ? item.product.name : 'N/A'}</td>
                                <td>${item.variant_id ? item.variant_label : 'N/A'}</td>
                                <td>${item.quantity}</td>
                                <td>${item.price}</td>
                                <td>${item.total_price} Taka</td>
                            </tr>
                        `;
                });

                $('#order_items').html(itemsHtml);
                $("#DataAdd").modal('show');
            }
        });
    });

    // update order approved status
    $(document).on('click', '.tableApproved', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.value) {
                let orderApprovedId = $(this).data('id');
                console.log(orderApprovedId);

                // Make AJAX request to make status approved in the order
                $.ajax({
                    url: "{{ route('admin.orders.approved') }}", // Use your route here
                    method: 'POST',
                    data: {
                        orderApprovedId: orderApprovedId,
                        _token: '{{ csrf_token() }}' // Make sure to pass CSRF token
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire("Success!", response.message, "success");
                        $('#dt-scroll-horizonal').DataTable().ajax
                            .reload(); // Refresh the DataTable
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Error!",
                            "There was an error while updating the order.",
                            "error");
                    }
                });
            } else {
                Swal.fire("Not Aapproved", "This order is not approved", "info");
            }
        });
    });

    // delivered Order
    $(document).on('click', '.tableDelivered', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delivered it!'
        }).then((result) => {
            if (result.value) {
                let orderDeliveredId = $(this).data('id');
                console.log(orderDeliveredId);

                // Make AJAX request to make status delivered in the order
                $.ajax({
                    url: "{{ route('admin.orders.delivered') }}", // Use your route here
                    method: 'POST',
                    data: {
                        orderDeliveredId: orderDeliveredId,
                        _token: '{{ csrf_token() }}' // Make sure to pass CSRF token
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire("Success!", response.message, "success");
                        $('#dt-scroll-horizonal').DataTable().ajax
                            .reload(); // Refresh the DataTable
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Error!",
                            "There was an error while updating the order.",
                            "error");
                    }
                });
            } else {
                Swal.fire("Not Delivered", "This order is not delivered", "info");
            }
        });
    });


    // canceled Order
    $(document).on('click', '.tableCancelled', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
            if (result.value) {
                let orderCancelId = $(this).data('id');
                console.log(orderCancelId);

                // Make AJAX request to cancel the order
                $.ajax({
                    url: "{{ route('admin.orders.cancelled') }}", // Use your route here
                    method: 'POST',
                    data: {
                        orderCancelId: orderCancelId,
                        _token: '{{ csrf_token() }}' // Make sure to pass CSRF token
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire("Success!", response.message, "success");
                        $('#dt-scroll-horizonal').DataTable().ajax
                            .reload(); // Refresh the DataTable
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Error!",
                            "There was an error while updating the order.",
                            "error");
                    }
                });
            } else {
                Swal.fire("Not Cancelled", "This order is not cancelled", "info");
            }
        });
    });

    $(document).on('click', '.tableDiscount', function() {
        let orderId = $(this).data('id');

        Swal.fire({
            title: 'Enter Discount Amount',
            input: 'number',
            inputAttributes: {
                min: 0
            },
            showCancelButton: true,
            confirmButtonText: 'Apply Discount',
            cancelButtonText: 'Cancel',
            preConfirm: (discountAmount) => {
                // you can use this to validate the input. Input must be greater then 0
                // if (!discountAmount || discountAmount <= 0) {
                //     Swal.showValidationMessage('Please enter a valid discount amount');
                // }
                if (discountAmount === '' || discountAmount < 0) {
                    Swal.showValidationMessage(
                        'Please enter a valid discount amount (0 or more)');
                }
                return discountAmount;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.orders.discount') }}",
                    method: 'POST',
                    data: {
                        orderId: orderId,
                        discountAmount: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success');
                        $('#dt-scroll-horizonal').DataTable().ajax.reload();

                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message ||
                            'Something went wrong', 'error');
                    }
                });
            }
        });
    });




});
</script>
@endpush
