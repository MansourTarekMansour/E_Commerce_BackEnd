@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Brand Details</h2>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h7 class="card-title">ID: {{ $brand->id }}</h7>
            <h5 class="card-title">Name: {{ $brand->name }}</h5>
            <p class="card-text">Created At: {{ $brand->created_at->format('d M, Y H:i') }}</p>
            <p class="card-text">Updated At: {{ $brand->updated_at->format('d M, Y H:i') }}</p>
            <div class="col-md-6">
                @if($brand->file)
                <strong>Image:</strong>
                <div>
                    <img src="{{ $brand->getImageUrl($brand->file->url) }}" alt="Customer Image" class="img-fluid" style="max-width: 200px;" />
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
