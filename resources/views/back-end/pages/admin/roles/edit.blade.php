@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Role')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Edit Role</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            class="form-check-input" id="perm_{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                        <label for="perm_{{ $permission->id }}"
                                            class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection