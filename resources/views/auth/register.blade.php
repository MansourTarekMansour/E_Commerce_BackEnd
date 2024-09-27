@extends('layouts.app')

@section('content')
<section class="gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card text-white" style="background-color: #2c3e50; border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-2 mt-md-2 pb-2">
                            <h2 class="fw-bold mb-2 text-uppercase">{{ __('Register') }}</h2>
                            <p class="text-white-50 mb-5">Please enter your details to register!</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-3">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-white-50 fw-bold">Login</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
