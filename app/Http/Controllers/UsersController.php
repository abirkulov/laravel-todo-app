<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UpdateRuleRequest;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use App\Models\User;

class UsersController extends Controller
{
    public function store()
    {
        $users = User::all();
        return view('users.store', compact(['users']));
    }

    public function editUserRole($id)
    {
        $roles = Role::all();
        $user = User::find($id);

        return view('users.edit-role', compact(['user', 'roles']));
    }

    public function updateUserRole(UpdateRuleRequest $request, $id)
    {
        $user = User::find($id);
        $newRoles = Role::find($request->roles);
        $oldRoles = $user->roles;

        foreach($oldRoles as $role) {
            $user->removeRole($role->name);
        }

        if($newRoles->isEmpty()) {
            setActionResponse('success', 
                'The roles have been successfully revoked from specific user!'
            );

            return redirect()->route('users.store');
        }

        $user->assignRole($newRoles);
        setActionResponse('success', 
            'The roles have been successfully assigned to specific user!'
        );

        return redirect()->route('users.store');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        setActionResponse('success', 'The user has been successfully deleted!');
        return redirect()->route('users.store');
    }
}
