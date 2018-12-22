<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        view()->share('page', 'user');    
    }

    public function store()
    {
        $users = User::all();
        return view('user.store', compact(['users']));
    }

    public function editUserRole($id)
    {
        $roles = Role::all();
        $user = User::with('roles.permissions')->find($id);

        return view('user.edit-role', compact(['user', 'roles']));
    }

    public function updateUserRole(UpdateRequest $request, $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $newRoles = Role::find($request->roles);
        $oldRoles = $user->roles;

        $user->removeRoles($oldRoles);

        if($newRoles->isEmpty()) {
            setActionResponse('success', __('messages.role.revoked'));
            return redirect()->route('user.store');
        }

        $user->assignRole($newRoles);
        setActionResponse('success', __('messages.role.assigned'));

        return redirect()->route('user.store');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        setActionResponse('success', __('messages.user.deleted'));
        return redirect()->route('user.store');
    }
}
