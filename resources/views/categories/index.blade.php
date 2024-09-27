@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Categories</h2>
        </div>
        <div class="pull-right d-flex align-items-center">
            @can('categories-create')
            <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('categories.create') }}"><i class="fa fa-plus"></i> Create New Category</a>
            @endcan
        </div>
    </div>
</div>

<div class="card-body p-0">
    <!-- Filter and Search Form -->
    <form method="GET" action="{{ route('categories.index') }}" class="d-flex flex-wrap align-items-center">
        <!-- Search input -->
        <div class="me-2 mb-1 me-2 d-flex flex-fill">
            <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search categories..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm ms-1"><i class="fa fa-search"></i></button>
        </div>

        <!-- Reset Button -->
        <div class="mb-1 d-flex">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
    </form>
</div>

<!-- Success message alert -->
@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<!-- Categories Table -->
<table class="table table-striped table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 5%;">ID</th>
            <th style="width: 75%;">Name</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td> <!-- Use $loop->iteration to display row number -->
            <td>{{ $category->name }}</td>
            <td>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    <a class="btn btn-info btn-sm" href="{{ route('categories.show', $category->id) }}"><i class="fa fa-eye"></i> Show</a>
                    @can('categories-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('categories.edit', $category->id) }}"><i class="fa fa-edit"></i> Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('categories-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination links -->
{!! $categories->links('vendor.pagination.custom-pagination') !!}

@endsection
