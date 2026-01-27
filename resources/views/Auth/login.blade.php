@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Welcome Back</h3>
                        <p class="text-muted">Please enter your details to sign in</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                            <label for="email">Email address</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>

                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePassword" style="z-index: 10; cursor: pointer;">
                                <i class="bi bi-eye-slash text-muted fs-5"></i>
                            </span>

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                            Sign In
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });

</script>
@endsection
