@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10"> <!-- Increased the column size from col-lg-8 to col-lg-10 -->
        <div class="card">
            <div class="card-header">
                <h2>Show User</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <h5 class="card-title"><strong>ID:</strong> {{ $user->id }}</h5>
                </div>

                <div class="form-group">
                    <strong>Name:</strong>
                    <p>{{ $user->name }}</p>
                </div>

                <div class="form-group">
                    <strong>Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>

                <div class="form-group mb-2">
                    <strong>Roles:</strong>
                    @if($user->getRoleNames()->isEmpty())
                    <h7>No roles assigned</h7>
                    @else
                    @foreach($user->getRoleNames() as $role)
                    <span class="badge badge-primary text-black">{{ $role }}</span>
                    @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <strong>Created At:</strong>
                    <p>{{ $user->created_at->format('d M, Y H:i') }}
                        ({{ $user->created_at->format('l') }}, {{ $user->created_at->diffForHumans() }})
                    </p>
                </div>

                <div class="form-group">
                    <strong>Updated At:</strong>
                    <p>{{ $user->updated_at->format('d M, Y H:i') }}
                        ({{ $user->updated_at->format('l') }}, {{ $user->updated_at->diffForHumans() }})
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection