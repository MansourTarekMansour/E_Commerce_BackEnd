@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Customer</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $customer->phone_number) }}" required>
        </div>

        <div class="form-group">
            <label for="blocked_until">Blocked Until</label>
            <input type="date" name="blocked_until" class="form-control" value="{{ old('blocked_until', $customer->blocked_until ? $customer->blocked_until->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @if ($customer->image)
                <div class="mt-2">
                    <label>Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $customer->image->url) }}" alt="Customer Image" style="max-width: 150px; height: auto;">
                    </div>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">New Password (leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-main mt-3">Update Customer</button>
    </form>
</div>
@endsection
