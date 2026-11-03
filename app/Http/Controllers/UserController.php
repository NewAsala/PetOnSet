<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('user.index')
            ->with('success', 'User added successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        // Change password only if admin entered a new one
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Replace old role with the new role
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('user.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent admin from deleting his own account
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('dashboard.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User deleted successfully.');
    }
}