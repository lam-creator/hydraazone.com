@extends('back-end.layout.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Permission')
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
                    <h5 class="box-title mr-auto p-2 mb-0">Edit Permission</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Permission Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $permission->name }}"
                                required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->


@endsection