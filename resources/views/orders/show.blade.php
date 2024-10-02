@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2>Order Details</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <strong>ID:</strong> {{ $order->id }}
                </div>

                <div class="form-group">
                    <strong>Customer:</strong> 
                    <a href="{{ route('customers.show', $order->customer->id) }}">
                        {{ $order->customer->name }}
                    </a>
                </div>

                <div class="form-group">
                    <strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }} <!-- Formatting the amount -->
                </div>

                <div class="form-group mb-2">
                    <strong>Status:</strong>
                    @if($order->status == 'completed')
                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                    @elseif($order->status == 'pending')
                        <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                    @elseif($order->status == 'cancelled')
                        <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <strong>Created At:</strong>
                    <p>{{ $order->created_at->format('d M, Y H:i') }} 
                       ({{ $order->created_at->format('l') }}, {{ $order->created_at->diffForHumans() }})
                    </p>
                </div>

                <div class="form-group">
                    <strong>Updated At:</strong>
                    <p>{{ $order->updated_at->format('d M, Y H:i') }} 
                       ({{ $order->updated_at->format('l') }}, {{ $order->updated_at->diffForHumans() }})
                    </p>
                </div>

                <div class="form-group">
                    <strong>Products:</strong>
                    @if($order->orderItems->isEmpty())
                        <p>No products found for this order.</p>
                    @else
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @foreach($order->orderItems as $orderItem)
                                    @if($orderItem->product)
                                        @php 
                                            $itemTotalPrice = $orderItem->quantity * $orderItem->price;
                                            $totalPrice += $itemTotalPrice;
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $orderItem->product->id) }}">
                                                    {{ $orderItem->product->name }}
                                                </a>
                                            </td>
                                            <td>{{ $orderItem->quantity }}</td>
                                            <td>${{ number_format($orderItem->price, 2) }}</td>
                                            <td>${{ number_format($itemTotalPrice, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                    <td><strong>${{ number_format($totalPrice, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
