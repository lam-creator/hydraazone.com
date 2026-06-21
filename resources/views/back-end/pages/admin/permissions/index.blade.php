@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Permissions List')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Permissions List</h5>
                    @if(Auth::guard('admin')->user()->can('permission.create'))
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-3">Create Permission</a>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Permission Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('permission.edit'))
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        @endif

                                        @if(Auth::guard('admin')->user()->can('permission.delete'))
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                            method="POST" style="display:inline;">
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