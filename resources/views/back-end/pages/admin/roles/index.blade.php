@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Roles List')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card mt-1">
                <div class="card-header d-flex">
                    <h5 class="box-title mr-auto p-2 mb-0">Roles List</h5>
                    @if(Auth::guard('admin')->user()->can('role.create'))
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">Create Role</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                        <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('role.edit'))
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        @endif

                                        @if(Auth::guard('admin')->user()->can('role.delete'))
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection