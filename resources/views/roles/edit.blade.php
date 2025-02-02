@extends('layouts.app')
@section('title', 'Edit Role')
@section('style')
<link href="{{ asset('assets/jquery_ui/jquery-ui.css')}}" rel="stylesheet" />
<style>
    .permission label{
        display: block;
    }

    #permission-card ul {
        width: 50%;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row ml-2 mr-2">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}" @if($role->name == 'Super Admin') readonly @endif>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <div class="row" id="permission-card">
                    @foreach ($permission as $group => $groupedPermissions)
                        <div class="col-3 card m-1 permission_group_position" 
                        data-group-position="{{$groupedPermissions['position_group']}}"
                        data-group-name="{{$groupedPermissions['group']}}">
                            <p><b>{{$groupedPermissions['group'] ?: 'Unassigned' }}</b></p>
                            <ul class="permission permission_position">
                                @foreach($groupedPermissions['data'] as $value)
                                    <label>
                                        <input type="checkbox" name="permission[{{$value['id']}}]" value="{{$value['id']}}"
                                            class="name" {{ in_array($value['id'], $rolePermissions) ? 'checked' : ''}}
                                            data-permission-position="{{ $value['position'] }}">
                                        {{ $value['name'] }}
                                    </label>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="fa-solid fa-floppy-disk"></i>
                Submit
            </button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{ asset('assets/jquery_ui/jquery-ui.js')}}"></script>
<script src="{{ asset('assets/custom_js/role_groups_permission_position.js')}}"></script>
@endsection