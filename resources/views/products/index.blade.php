@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Products</h2>
        </div>
        <div class="pull-right">
            @can('products-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('products.create') }}"><i class="fa fa-plus"></i> Create New Product</a>
            @endcan
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" role="alert"> 
        {{ session('success') }}
    </div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 4%;">No</th>
            <th style="width: 20%;">Name</th> <!-- Increased width for Name -->
            <th style="width: 10%;">Price</th>
            <th style="width: 13%;">Discount Price</th>
            <th style="width: 13%;">Quantity in Stock</th> <!-- Decreased width for Quantity in Stock -->
            <th style="width: 10%;">Category</th>
            <th style="width: 10%;">Brand</th>
            <th style="width: 20%;">Action</th> <!-- Slightly reduced action column -->
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>${{ number_format($product->discount_price, 2) }}</td>
            <td>{{ $product->quantity_in_stock }}</td>
            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
            <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td>
            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-info btn-sm" href="{{ route('products.show',$product->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    @can('products-edit')
                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit',$product->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')

                    @can('products-delete')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links() !!}

@endsection
