@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create New Admin')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">Create New Admin</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.admins.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>


                        <div class="mb-3">
                            <label>User Name</label>
                            <input type="text" name="username" placeholder="User Name" class="form-control" required value="{{ old('username') }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="" selected>Select status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Assign Roles</label>
                            @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                    value="{{ $role->name }}">
                                <label class="form-check-label">{{ $role->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Create Admin</button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection