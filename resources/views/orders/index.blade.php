@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Orders</h2>
        </div>
        <!-- <div class="pull-right d-flex align-items-center">
            @can('orders-create')
            <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('orders.create') }}"><i class="fa fa-plus"></i> Create New Order</a>
            @endcan
        </div> -->
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
            <th style="width: 5%;">No</th>
            <th style="width: 25%;">Customer</th>
            <th style="width: 15%;">Total Amount</th>
            <th style="width: 15%;">Order Status</th>
            <th style="width: 30%;">Created At</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
            <td>
                @if($order->status == 'completed')
                    <span class="badge bg-success">{{ ucfirst($order->status) }}</span> <!-- Green for Completed -->
                @elseif($order->status == 'pending')
                    <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span> <!-- Yellow for Pending -->
                @elseif($order->status == 'cancelled')
                    <span class="badge bg-danger">{{ ucfirst($order->status) }}</span> <!-- Red for Cancelled -->
                @else
                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span> <!-- Grey for Other statuses -->
                @endif
            </td>
            <td>
                <p>
                    {{ $order->created_at->format('d M, Y H:i') }} 
                    ({{ $order->created_at->format('l') }}, {{ $order->created_at->diffForHumans() }})
                </p>
            </td>
            <td>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    <a class="btn btn-info btn-sm" href="{{ route('orders.show', $order->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    <!-- @can('orders-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('orders.edit', $order->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan -->

                    @csrf
                    @method('DELETE')

                    <!-- @can('orders-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endcan -->
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $orders->links('vendor.pagination.custom-pagination') !!}
<!-- Use the PerPageSelector component -->
<x-per-page-selector :route="'orders.index'" :perPage="$perPage" />

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
