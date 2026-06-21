@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create Role')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Create Role</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            class="form-check-input" id="perm_{{ $permission->id }}">
                                        <label for="perm_{{ $permission->id }}"
                                            class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Create</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection