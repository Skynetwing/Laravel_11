@extends('layouts.app')
@section('title', 'Settings')
@section('style')
    <link href="{{ asset('') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Settings</h2>
            </div>
            @can('user-create')
                <div class="pull-right">
                    <a class="btn btn-success mb-2" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New
                        User</a>
                </div>
            @endcan
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('') }}"></script>
@endsection
