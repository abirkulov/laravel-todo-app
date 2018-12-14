<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use App\Http\Requests\Roles\UpdateRequest;
use App\Http\Requests\Roles\CreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-roles');
    }

    public function store()
    {
        $roles = Role::all();
        return view('roles.store', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function save(CreateRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        setActionResponse('success', 'The role has been successfully added!');
        return redirect()->route('roles.store');
    }

    public function edit(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('roles.edit', compact(['role', 'permissions']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $roleData = $request->except(['_token', 'permissions']);
        $role = Role::where('name', $request->name)->first();

        if($role && $role->id != $id) {
            session()->flash('name',
                'The role with this name already exists. Choose another one.'
            );

            return redirect()->back()->withInput();
        }

        $role = Role::find($id);
        $permissions = $role->permissions;

        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        $role->update(['name' => $request->name]);

        setActionResponse('success', 'The category has been successfully updated!');
        return redirect()->route('roles.store');
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        setActionResponse('success', 'The role has been successfully deleted!');
        return redirect()->route('roles.store');
    }
}
