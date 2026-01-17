<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(
            (int) $request->query('per_page', 10),
            50
        );
        
        $users = User::query()
            ->search($request->query('search'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Displays from for deleting resource.
     */
    public function delete(User $user) {
        return view('users.delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if (Auth::user()->cannot('delete', User::class)) {
            abort(403);
        }

        $expected = __('users.delete_prompt', ['name' => $user->name]);

        $request->validate([
            'deletion_confirmation' => ['required', 'string'],
        ]);

        if ($request->deletion_confirmation !== $expected) {
            return back()->withErrors([
                'deletion_confirmation' => 'Confirmation text does not match.',
            ]);
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('status', 'User deleted successfully.');
    }
}
