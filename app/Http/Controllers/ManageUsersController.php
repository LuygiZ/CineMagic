<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
        $newUser = User::create($request->validated());
        $url = route('manageUsers.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function update(ManageUsersRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());
        $url = route('manageUsers.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";
        return redirect()->route('manageUsers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

}
