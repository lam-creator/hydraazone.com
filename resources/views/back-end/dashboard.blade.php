@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Dashboard')
@section('content')

<div class="row">

    <!-- col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $TotalAdmin }}</h3>

                <p>Total Admins</p>
            </div>
        </div>
    </div>
    <!-- ./col -->

    <!-- col -->
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.customer') }}">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $TotalUser }}</h3>

                    <p>Total User</p>
                </div>
            </div>
        </a>
    </div>
    <!-- ./col -->


</div>
<!-- /.row -->


<div class="row">

    <!-- col -->
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.processing.orders.index') }}">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $TotalProcessingOrder }}</h3>

                    <p>Total New Orders</p>
                </div>
            </div>
        </a>
    </div>
    <!-- ./col -->

    <!-- col -->
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.approved.orders.index') }}">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $TotalApprovedOrder }}</h3>

                    <p>Total Approved Order</p>
                </div>
            </div>
        </a>
    </div>
    <!-- ./col -->

    <!-- col -->
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.delivered.orders.index') }}">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $TotalDeliveredOrder }}</h3>

                    <p>Total Delivered Order</p>
                </div>
            </div>
        </a>
    </div>
    <!-- ./col -->

    <!-- col -->
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.cancelled.orders.index') }}">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $TotalCancelledOrder }}</h3>

                    <p>Total Cancelled Order</p>
                </div>
            </div>
        </a>
    </div>
    <!-- ./col -->



</div>
<!-- /.row -->


{{-- <div class="row">
  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
     Launch Default Modal
  </button>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Default Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

</div> --}}
<!-- /.row -->

<!-- Sweetalert -->
{{-- <div class="row mt-2">
  <div class="col-lg-12">
    <button class="btn btn-primary sweetalert">Click</button>
    <button class="btn btn-primary sweetalertMixin">Click Mixin</button>
  </div>
</div> --}}

<!-- Summernote -->
{{-- <div class="row mt-2">
  <div class="col-lg-12">
    <div id="summernote"></div>
  </div>
</div> --}}

<!-- Page specific script -->
<script>
$(document).ready(function() {

    $('.sweetalert').click(function() {
        Swal.fire("Success", "Data updated successfully", "success");
    });

    $('.sweetalertMixin').click(function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Data updated successfully',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
        });
    });


});
</script>


@endsection