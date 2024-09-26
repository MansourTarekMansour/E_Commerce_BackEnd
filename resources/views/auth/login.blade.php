@extends('layouts.app')

@section('content')
<section class="gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card text-white" style="background-color: #2c3e50; border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-2 mt-md-2 pb-2">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="typeEmailX" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input id="typePasswordX" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-check mb-4 text-start">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" />
                                    <label class="form-check-label text-white" for="rememberMe">Remember Me</label>
                                </div>

                                <p class="small mb-3 pb-lg-2">
                                    <a class="text-white-50" href="{{ route('password.request') }}">Forgot password?</a>
                                </p>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-white-50 fw-bold">Sign Up</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
