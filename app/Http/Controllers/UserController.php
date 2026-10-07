<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {

            // Admin can see everyone.
            $users = User::orderBy('name')->paginate(20);

        } else {

            // Manager can only see staff.
            $users = User::where('role', 'staff')
                ->orderBy('name')
                ->paginate(20);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        return view('users.create', compact('allowedRoles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:' . implode(',', $allowedRoles)],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(User $user)
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        return view('users.edit', compact('user', 'allowedRoles'));
    }

    /**
     * Update a user.
     */
    public function update(Request $request, User $user)
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
            'role' => ['required', 'in:' . implode(',', $allowedRoles)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot delete your own account.',
            ]);
        }

        $allowedRoles = $this->allowedRolesForCurrentUser();

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Roles this logged-in user is allowed to manage.
     */
    private function allowedRolesForCurrentUser(): array
    {
        return match (auth()->user()->role) {
            'admin' => ['admin', 'manager', 'staff'],
            'manager' => ['staff'],
            default => [],
        };
    }
}