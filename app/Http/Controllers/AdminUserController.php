<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $users = User::query()
            ->whereIn('role', ['student', 'tutor', 'admin'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => [
                'required',
                Rule::in(['student', 'tutor', 'admin']),
            ],
        ]);

        // Do not allow an admin to change their own role here.
        if ($user->id === $request->user()->id) {
            return back()->with(
                'error',
                'You cannot change your own role.'
            );
        }

        // Prevent the last administrator from losing admin access.
        if (
            $user->role === 'admin' &&
            $validated['role'] !== 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->with(
                'error',
                'You cannot remove the last administrator.'
            );
        }

        $user->role = $validated['role'];
        $user->save();

        return back()->with(
            'success',
            "Role updated successfully for {$user->name}."
        );
    }
}
