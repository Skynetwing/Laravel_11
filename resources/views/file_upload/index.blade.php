@extends('layouts.app')
@section('title', 'File Upload with Progress Bar')
@section('style')
    <link href="{{ asset('') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>File Upload with Progress Bar</h2>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="fileUploadForm" action="{{ route('file.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    <div id="progressBar" class="progress mt-3" style="display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            style="width: 0%;" id="progressBarFill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $('#progressBar').show();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progressBarFill').css('width', percentComplete +
                                    '%');
                                $('#progressBarFill').text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        alert('File uploaded successfully!');
                        $('#progressBar').hide();
                        $('#progressBarFill').css('width', '0%').text('');
                    },
                    error: function(error) {
                        alert('Error uploading file.');
                        $('#progressBar').hide();
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('') }}"></script>
@endsection
