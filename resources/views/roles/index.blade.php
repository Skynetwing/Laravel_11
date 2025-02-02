@extends('layouts.app')
@section('title', 'Role Management')
@section('style')
<link href="{{ asset('assets/jquery_ui/jquery-ui.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between">
        <div class="pull-left">
            <h2>Role Management</h2>
        </div>
        <div class="pull-right">
            @can('role-create')
                <a class="btn btn-success btn-sm mb-2" href="{{ route('roles.create') }}"><i class="fa fa-plus"></i> Create
                    New Role</a>
            @endcan
        </div>
    </div>
</div>

<table class="table table-bordered">
    <tr>
        <th width="100px">No</th>
        <th>Name</th>
        <th width="280px">Action</th>
    </tr>
    <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i
                            class="fa-solid fa-list"></i>
                        Show</a>
                    @can('role-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan

                    @can('role-delete')
                        @if ($role->name != "Super Admin")
                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                        @endif
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('script')
<script src="{{ asset('assets/jquery_ui/jquery-ui.js')}}"></script>
<script>
    $(function () {
        $('tbody').sortable();
    });
</script>
@endsection