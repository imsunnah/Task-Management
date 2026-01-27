@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    {{-- Page Header --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Team Directory</h2>
            <p class="text-muted mb-0">Manage employee accounts and system access.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            @if (auth()->user()->isAdmin())
            <a href="{{ route('users.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Member
            </a>
            @endif
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 py-3">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Main Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0">Member</th>
                        <th class="py-3 border-0">Contact</th>
                        <th class="py-3 border-0 text-center">Status</th>
                        @if (auth()->user()->isAdmin())
                        <th class="text-end pe-4 py-3 border-0">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff" class="rounded-circle" width="45" alt="User">
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted small">ID: #00{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">
                            <i class="bi bi-envelope-at me-1"></i> {{ $user->email }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-medium">Active</span>
                        </td>
                        @if (auth()->user()->isAdmin())
                        <td class="text-end pe-4">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-light btn-sm rounded-3 me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-soft-danger btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                        @endif
                    </tr>

                    {{-- Unique Modal for each User --}}
                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">
                                <div class="modal-body p-5 text-center">
                                    <div class="mb-4">
                                        <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-exclamation-triangle fs-1"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold text-dark">Confirm Deletion</h3>
                                    <p class="text-muted px-4">Are you sure you want to remove <strong>{{ $user->name }}</strong>? All associated data will be permanently archived.</p>

                                    <div class="d-grid gap-2 d-md-flex justify-content-center mt-4 pt-2">
                                        <button type="button" class="btn btn-light px-4 py-2 rounded-3 fw-semibold text-muted" data-bs-dismiss="modal">No, keep them</button>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold shadow-sm">Yes, delete account</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom Stylings */
    .btn-soft-danger {
        background-color: #fee2e2;
        color: #ef4444;
        border: none;
    }

    .btn-soft-danger:hover {
        background-color: #ef4444;
        color: white;
    }

    .card {
        border-radius: 1rem;
    }

    .table thead th {
        letter-spacing: 0.05em;
    }

    .modal-content {
        border-radius: 1.5rem;
    }

    .icon-shape {
        transition: transform 0.3s ease;
    }

    .modal:hover .icon-shape {
        transform: scale(1.1) rotate(5deg);
    }

</style>
@endsection
