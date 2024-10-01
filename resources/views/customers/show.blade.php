@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customer Details</h2>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $customer->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <p> <strong>ID: </strong>{{ $customer->id }}</p> 
                    
                        <strong>Name:</strong>
                        <p>{{ $customer->name }}</p>

                        <strong>Email:</strong>
                        <p>{{ $customer->email }}</p>

                        <strong>Phone Number:</strong>
                        <p>{{ $customer->phone_number }}</p>

                        <strong>Blocked Until:</strong>
                        <p>{{ $customer->blocked_until ? $customer->blocked_until->format('Y-m-d H:i:s') : 'Not Blocked' }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($customer->image)
                            <strong>Image:</strong>
                            <div>
                                <img src="{{ $customer->getImageUrl($customer->image->url) }}" alt="Customer Image" class="img-fluid" style="max-width: 200px;"/>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Orders Section --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Orders</h5>
            </div>
            <div class="card-body">
                @if($customer->orders->isEmpty())
                    <p>No orders found for this customer.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <ul style="list-style-type: none; padding: 0;">
                                            @foreach($order->orderItems as $orderItem)
                                                @if($orderItem->product)
                                                    <li>
                                                        <a href="{{ route('products.show', $orderItem->product->id) }}">
                                                            {{ $orderItem->product->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


{{-- Cart Section --}}
@if($customer->cart && $customer->cart->cartItems->isNotEmpty())
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Cart</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->cart->cartItems as $cartItem)
                            <tr>
                                <td>{{ $cartItem->product_id }}</td>
                                <td>
                                    <a href="{{ route('products.show', $cartItem->product_id) }}">
                                        {{ $cartItem->product->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $cartItem->product->price ?? 'N/A' }}</td>
                                <td>{{ $cartItem->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif


@endsection
