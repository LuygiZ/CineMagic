<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageUsersRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageUsersController extends Controller
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

        debug($users);
        return view('manageUsers.index', compact('allUsers', 'filterByType', 'filterByBlocked', 'filterByName'));
    }

    public function show(User $user): View
    {
        return view('manageUsers.show')->with('user', $user);
    }

    public function edit(User $user): View
    {
        return view('manageUsers.edit')->with('user', $user);
    }

    public function create(): View
    {
        $newUser = new User();
        return view('manageUsers.create')->with('user', $newUser);
    }

    public function store(ManageUsersRequest $request): RedirectResponse
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
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'blocked' => $request->blocked,
                'password' => Hash::make($request->password),
            ]);
        }

        $url = route('manageUsers.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $user): RedirectResponse
    {
        if($user->type == 'C'){
            $url = route('manageUsers.index');
            $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> não pode ser apagado!";
            return redirect()->route('manageUsers.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        $user->delete();
        $url = route('manageUsers.index');
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been deleted successfully!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function update(ManageUsersRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if ($user->photo_filename &&
                    Storage::fileExists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
            }

            $path = $request->photo_file->store('public/photos');
            $user->photo_filename = basename($path);
            $user->save();
        }

        $url = route('manageUsers.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function updateBlocked(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->blocked = $request->input('blocked');
        $user->save();

        $url = route('manageUsers.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> está agora " . ($user->blocked ? 'bloqueado' : 'desbloqueado') . "!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

}
