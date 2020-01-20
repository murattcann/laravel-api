@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div id="output" class="container">

                </div>
                <div class="card-body">
                    <form role="form" class="form" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="form-group">
                            <label for="uploadFile" class="">Select File</label>
                            <input type="file" id="uploadFile" class="form-control">
                        </div>

                        <input type="submit" id="uploadButton" class="btn btn-primary" value="Upload">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("footer")
    <script>
        (function () {
            var output = document.getElementById('output');
            document.getElementById('uploadButton').onclick = function () {
                var data = new FormData();
                data.append('userID', '1');
                data.append('file', document.getElementById('uploadFile').files[0]);

                var config = {
                    onUploadProgress: function(progressEvent) {
                        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                };

                axios.post('http://127.0.0.1:8000/api/upload', data, config)
                    .then(function (res) {
                        output.innerHTML = res.data.url;
                    })
                    .catch(function (err) {
                        output.className = 'text-danger';
                        output.innerHTML = err.message;
                    });
            };
        })();
    </script>
@endsection
