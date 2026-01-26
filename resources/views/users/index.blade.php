@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees</h1>

    @if (auth()->user()->isAdmin())
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
    @endif

    @if ($users->isEmpty())
    <div class="alert alert-info">
        @if (auth()->user()->isAdmin())
        No employees found. Add one using the button above.
        @else
        You don't have permission to manage users.
        @endif
    </div>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                @if (auth()->user()->isAdmin())
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if (auth()->user()->isAdmin())
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this employee?')">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
