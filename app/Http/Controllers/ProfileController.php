<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Customer;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
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

        if($request->has('nif')){
            $customer = Customer::find($request->user()->id);
            $customer->nif = $request->nif;

            // Validação para payment_type
            $validPaymentTypes = ['VISA', 'PAYPAL', 'MBWAY', 'NONE'];
            if(in_array($request->payment_type, $validPaymentTypes)){
                $customer->payment_type = $request->payment_type == 'NONE' ? null : $request->payment_type;
            } else {
                $customer->payment_type = null;
            }

            $customer->save();
        }

        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if ($request->user()->photo_filename &&
                    Storage::fileExists('public/photos/' . $request->user()->photo_filename)) {
                    Storage::delete('public/photos/' . $request->user()->photo_filename);
            }

            $path = $request->photo_file->store('public/photos');
            $request->user()->photo_filename = basename($path);
            $request->user()->save();
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Utilizador atualizado com sucesso.");
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
}
