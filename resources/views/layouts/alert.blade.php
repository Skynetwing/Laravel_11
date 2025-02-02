@session('success')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $value }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endsession

@session('error')
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        {{ $value }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endsession

@session('info')
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ $value }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endsession

@session('warning')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ $value }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endsession

@if (count($errors) > 0)
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif