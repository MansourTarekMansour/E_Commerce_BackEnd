@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Brand Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('brands.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $brand->name }}</h5>
            <p class="card-text">Created At: {{ $brand->created_at->format('d M, Y H:i') }}</p>
            <p class="card-text">Updated At: {{ $brand->updated_at->format('d M, Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection
