@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Brands</h2>
        </div>
        <div class="pull-right d-flex align-items-center">
            @can('brands-create')
            <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('brands.create') }}"><i class="fa fa-plus"></i> Create New Brand</a>
            @endcan
        </div>
    </div>
</div>

<div class="card-body p-0">
    <form method="GET" action="{{ route('brands.index') }}" class="d-flex flex-wrap align-items-center">
        <div class="me-2 mb-1 me-2 d-flex flex-fill">
            <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search bands..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm ms-1"><i class="fa fa-search"></i></button>
        </div>

        <!-- Reset Button -->
        <div class="mb-1 d-flex">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
    </form>
</div>

@if(session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped table-bordered mt-3">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 75%;">Name</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($brands as $brand)
        <tr>
            <td>{{ ++$i }}</td> <!-- Loop iteration for row number -->
            <td>{{ $brand->name }}</td>
            <td>
                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                    <a class="btn btn-info btn-sm" href="{{ route('brands.show', $brand->id) }}"><i class="fa-solid fa-list"></i> Show</a>

                    @can('brands-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('brands.edit', $brand->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    @can('brands-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $brands->links('vendor.pagination.custom-pagination') !!}
 <!-- Use the PerPageSelector component -->
<x-per-page-selector :route="'brands.index'" :perPage="$perPage" />
<script>
    // Automatically hide the alert after a certain time (e.g., 5 seconds)
    window.onload = function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s ease"; // Add a fade-out transition
                alert.style.opacity = 0; // Fade out the alert
                setTimeout(() => {
                    alert.remove(); // Remove the alert from the DOM after fading out
                }, 500); // Match this duration with the transition time
            }, 3000); // Time in milliseconds to wait before hiding the alert
        }
    };
</script>
@endsection