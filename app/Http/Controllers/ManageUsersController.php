<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageUsersController extends Controller
{
    public function index(): View
    {
        $allUsers = User::paginate(15);
        debug($allUsers);
        return view('manageUsers.index')->with('allUsers', $allUsers);
    }

    public function show(User $user): View
    {
        return view('manageUsers.show')->with('user', $user);
    }

    public function edit(User $user): View
    {
        return view('manageUsers.edit')->with('user', $user);
    }
}
