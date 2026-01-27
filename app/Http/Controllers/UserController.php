<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        try {
            DB::transaction(function () use ($request) {

                User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'employee',
                ]);
            });

            return redirect()->route('users.index')
                ->with('success', 'Employee created successfully.');
        } catch (\Throwable $e) {

            Log::error('User creation failed', [
                'payload' => $request->validated(),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors('Could not create employee account.');
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::transaction(function () use ($request, $user) {

                $data = $request->validated();

                if (empty($data['password'])) {
                    unset($data['password']);
                } else {
                    $data['password'] = Hash::make($data['password']);
                }

                $user->update($data);
            });

            return redirect()->route('users.index')
                ->with('success', 'Employee updated successfully.');
        } catch (\Throwable $e) {

            Log::error('User update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors('Could not update employee details.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Employee deleted successfully.');
        } catch (\Throwable $e) {

            Log::error('User deletion failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(
                'Employee cannot be deleted. They may be assigned to tasks or events.'
            );
        }
    }
}
