@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Category Details</h2>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h7 class="card-title">ID: {{ $category->id }}</h7>
            <h5 class="card-title">Name: {{ $category->name }}</h5>
            <p class="card-text">Created At: {{ $category->created_at }}</p>
            <p class="card-text">Updated At: {{ $category->updated_at }}</p>
        </div>
    </div>
</div>
@endsection