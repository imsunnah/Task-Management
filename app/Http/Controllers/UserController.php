<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'employee')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role']     = 'employee';

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(User $user)
    {
        // Optional: extra protection layer (good practice)
        if ($user->isAdmin()) {
            abort(403, 'Administrator accounts cannot be edited here.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Administrator accounts cannot be edited here.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Cannot delete administrator accounts.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
