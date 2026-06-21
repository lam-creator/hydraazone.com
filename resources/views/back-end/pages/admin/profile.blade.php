@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin profile')
@section('content')

<div class="row">

    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">

                    @if (!is_null($admin->image))
                        <img src="/uploads/admin/{{ $admin->image }}" class="profile-user-img img-fluid img-circle" alt="{{ $admin->name }} Picture" >
                    @else
                        <img src="/back-end/dist/img/user1-128x128.jpg" class="profile-user-img img-fluid img-circle" alt="{{ $admin->name }} Picture" >
                    @endif

                </div>

                <h3 class="profile-username text-center">{{ $admin->name }}</h3>
                <p class="text-muted text-center">Email : {{ $admin->email }}</p>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->


    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <h3 class="card-title">Update Password</h3>
            </div><!-- /.card-header -->

            <div class="card-body">
                <form class="form-horizontal" method="post" action="{{ route('admin.password-update', $admin->id) }}">
                    @csrf

                    <div class="form-group row">
                        <label for="old_password" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="old_password" name="old_password" class="form-control" required>
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new_password_confirmation" class="col-sm-2 col-form-label">Confirm New Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                            @error('new_password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </div>
                </form>

            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div>
<!-- /.row -->

@endsection
