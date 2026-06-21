@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin List')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Admins</h5>
                    @if(Auth::guard('admin')->user()->can('admin.create'))
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-3">Create New Admin</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach($admin->roles as $role)
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('admin.edit'))
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        @endif

                                        @if(Auth::guard('admin')->user()->can('admin.delete'))
                                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-danger">Delete</button>
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