@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Create New Employee</h2>
                    <p class="text-muted">Register a new team member and assign their credentials.</p>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12 mb-2">
                                <h5 class="fw-bold border-start border-primary border-4 ps-3">Personal Details</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                                    <label for="name">Full Name</label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@company.com" value="{{ old('email') }}" required>
                                    <label for="email">Email Address</label>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-5 mb-2">
                                <h5 class="fw-bold border-start border-primary border-4 ps-3">Security & Password</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePassword">
                                        <i class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-text mt-2 small text-muted">Use at least 8 characters with numbers and symbols.</div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <hr class="text-muted opacity-25 mb-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-light px-4 rounded-3">Clear Form</button>
                                    <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3 shadow-sm">
                                        <i class="bi bi-person-check-fill me-2"></i>Create Employee
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password Script (same as before)
    document.querySelector('#togglePassword').addEventListener('click', function() {
        const password = document.querySelector('#password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });

</script>
@endsection
