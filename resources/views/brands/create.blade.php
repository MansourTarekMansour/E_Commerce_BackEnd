@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Brand</h2>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Brand Name" required>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image:</strong>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            </div>
        </div>

        <!-- Image Preview -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <img id="image-preview" style="max-width: 200px; display: none;" />
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-main mt-3">Submit</button>
        </div>
    </div>
</form>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        // Check if there's a file selected
        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            // If no file is selected, hide the image preview
            document.getElementById('image-preview').style.display = 'none';
        }
    }
</script>

@endsection
