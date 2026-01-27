@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Breadcrumb / Back Link --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <a href="{{ route('users.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Employee Directory
                </a>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Header with Profile Intro --}}
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=128" class="rounded-circle shadow-sm" width="64" alt="User Avatar">
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">Edit Profile</h3>
                            <p class="text-muted mb-0">Updating information for <strong>{{ $user->name }}</strong></p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Account Details Section --}}
                            <div class="col-12">
                                <h6 class="text-primary fw-bold text-uppercase small tracking-wider mb-3">Account Information</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name) }}" required>
                                    <label for="name">Full Name</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            {{-- Security Section --}}
                            <div class="col-12 mt-4">
                                <div class="p-3 rounded-3 bg-light border-start border-primary border-4">
                                    <h6 class="fw-bold mb-1">Security Update</h6>
                                    <p class="text-muted small mb-0">Leave password fields blank if you don't want to change the current password.</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="New Password">
                                    <label for="password">New Password</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="col-12 mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Last updated: {{ $user->updated_at->diffForHumans() }}</span>
                                    <div>
                                        <a href="{{ route('users.index') }}" class="btn btn-light px-4 rounded-3 me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-5 rounded-3 fw-bold shadow-sm">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-floating>.form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }

    .tracking-wider {
        letter-spacing: 0.1em;
    }

</style>
@endsection
