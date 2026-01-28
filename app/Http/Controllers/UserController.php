<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
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

    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'employee',
            ]);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {

            $data = $request->validated();

            if (! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (QueryException $e) {
            return back()->withErrors(
                'Employee cannot be deleted because they are assigned to tasks or events.'
            );
        }

        return redirect()->route('users.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
