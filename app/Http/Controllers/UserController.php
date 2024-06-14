<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::paginate(15);
        $filterByType = $request->query('type');
        $filterByBlocked = $request->query('blocked');
        $filterByName = $request->query('name');

        $usersQuery = User::query();

        if ($filterByType !== null) {
            $usersQuery->where('type', $filterByType);
        }

        if ($filterByBlocked !== null) {
            $usersQuery->where('blocked', $filterByBlocked);
        }

        if($filterByName !== null){
            $usersQuery->where('name', 'like', '%' . $filterByName . '%');
        }

        $allUsers = $usersQuery
        ->paginate(20)
        ->withQueryString();

        return view('users.index', compact('allUsers', 'filterByType', 'filterByBlocked', 'filterByName'));
    }

    public function show(User $user): View
    {
        return view('users.show')->with('user', $user);
    }

    public function edit(User $user): View
    {
        return view('users.edit')->with('user', $user);
    }

    public function create(): View
    {
        $newUser = new User();
        return view('users.create')->with('user', $newUser);
    }

    public function store(UserFormRequest $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validatedData = $request->validated();

        if($request->type == "C"){
            $newUser = DB::transaction(function () use ($validatedData, $request) {

                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'blocked' => $request->blocked,
                    'password' => Hash::make($request->password),
                ]);
                $newCustomer = new Customer();
                $newCustomer->id = $newUser->id;
                $newCustomer->save();

                if ($request->hasFile('photo_file')) {
                    $path = $request->photo_file->store('public/photos');
                    $newUser->photo_filename = basename($path);
                    $newUser->save();
                }
                return $newUser;
            });

        }else{
            $newUser = DB::transaction(function () use ($validatedData, $request) {

                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'blocked' => $request->blocked,
                    'password' => Hash::make($request->password),
                ]);

                if ($request->hasFile('photo_file')) {
                    $path = $request->photo_file->store('public/photos');
                    $newUser->photo_filename = basename($path);
                    $newUser->save();
                }
                return $newUser;
            });


        }

        $htmlMessage = "User $newUser->name has been created successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $user): RedirectResponse
    {
        if($user == Auth::user()){
            $htmlMessage = "User $user->name cannot be deleted (current user)!";
            return redirect()->route('users.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        if($user->type == 'C'){
            $htmlMessage = "User {$user->name} cannot be deleted (client)";
            return redirect()->route('users.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        $user->delete();
        $htmlMessage = "User {$user->name} has been deleted successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function update(UserFormRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $request, $user) {

            $user->update($validatedData);

            if(!Customer::find($user->id)){
                $newCustomer = new Customer();
                $newCustomer->id = $user->id;
                $newCustomer->save();
            }

            if ($request->hasFile('photo_file')) {
                if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
                }

                $path = $request->photo_file->store('public/photos');
                $user->photo_filename = basename($path);
                $user->save();
            }
        });

        $htmlMessage = "User $user->name updated successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function updateBlocked(Request $request, $id)
    {
        if($id == Auth::user()->id){
            $htmlMessage = "It is not possible to block the user himself";
            return redirect()->route('users.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        $user = User::findOrFail($id);
        $user->blocked = $request->input('blocked');
        $user->save();

        $htmlMessage = "User $user->name is now " . ($user->blocked ? 'blocked' : 'active') . "!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroyPhoto(User $user): RedirectResponse
    {
        if ($user->photo_filename) {
            if (Storage::fileExists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $user->photo_filename = null;
            $user->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo from user {$user->name} deleted successfully");
        }
        return redirect()->back();
    }

    public function updatePhoto(UserFormRequest $request, User $user)
    {

        if ($request->hasFile('photo_file')) {
            if ($user->photo_filename &&
                    Storage::fileExists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
            }

            $path = $request->photo_file->store('public/photos');
            $user->photo_filename = basename($path);
            $user->save();

        }
        return view('users.show')->with('user', $user);
    }

}
