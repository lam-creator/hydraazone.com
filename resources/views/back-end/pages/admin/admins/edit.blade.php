@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Admin')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Edit Admin: {{ $admin->name }}</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required
                                value="{{ old('name', $admin->name) }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required
                                value="{{ old('email', $admin->email) }}">
                        </div>

                        <div class="mb-3">
                            <label>New Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Assign Roles</label>
                            @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    {{ $admin->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $role->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update Admin</button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection