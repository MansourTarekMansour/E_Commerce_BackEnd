@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customers</h2>
        </div>
        <div class="pull-right d-flex align-items-center">
            @can('customers-create')
            <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('customers.create') }}"><i class="fa fa-plus"></i> Create New Customer</a>
            @endcan
        </div>
    </div>
</div>


@if(session('success'))
<div id="success-alert" class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th width="250px">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone_number }}</td>
            <td>
                <form action="{{ route('customers.destroy',$customer->id) }}" method="POST">
                    <a class="btn btn-info btn-sm" href="{{ route('customers.show',$customer->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    @can('customers-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('customers.edit',$customer->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    @can('customers-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $customers->links('vendor.pagination.custom-pagination') !!}
<!-- Use the PerPageSelector component -->
<x-per-page-selector :route="'customers.index'" :perPage="$perPage" />
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