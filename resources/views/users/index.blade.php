@extends('layouts.app')
@section('title', 'Users Management')
@section('style')
<link href="{{ asset('assets/jquery_ui/jquery-ui.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        @can('user-create')
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New
                User</a>
        </div>
        @endcan
    </div>
</div>
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    <tbody>
        @foreach ($data as $key => $user)
            <tr>
                <td class="table_id">{{ ++$i }}</td>
                <td>
                    @if($user->user_pic)
                        <a href="{{ url($user->user_pic) }}" target="_blank">
                            <img src="{{ url($user->user_pic) }}" alt="User Pic" width="50" height="50">
                        </a>
                    @else
                        <img src="{{ asset('assets/images/user.png') }}" alt="Default Pic" width="50" height="50">
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <label class="badge bg-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}"><i
                            class="fa-solid fa-list"></i>
                        Show</a>
                    @can('user-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan
                    @can('user-delete')
                        @if (empty($v) || $v != "Super Admin")
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
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