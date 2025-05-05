<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        $requests = \App\Models\User::where('status_permintaan', 'pending')->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'requests' => $requests,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function requestRoleChange(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'pengguna') {
            return Redirect::route('profile.edit')->with('error', 'Invalid role for request.');
        }

        $user->status_permintaan = 'pending'; // Tandai permintaan sebagai pending
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'request-sent');
    }
    
    public function approveRoleChange($userId): RedirectResponse
    {
        $user = \App\Models\User::findOrFail($userId);

        if ($user->status_permintaan !== 'pending') {
            return Redirect::back()->with('error', 'No pending request found.');
        }

        $user->role = 'penduduk';
        $user->status_permintaan = null;
        $user->save();

        return Redirect::back()->with('status', 'request-approved');
    }
}
