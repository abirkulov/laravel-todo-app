<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Requests\Role\CreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-roles');
    }

    public function store()
    {
        $roles = Role::all();
        return view('role.store', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function save(CreateRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        setActionResponse('success', 'The role has been successfully added!');
        return redirect()->route('role.store');
    }

    public function edit(Request $request, $id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();

        return view('role.edit', compact(['role', 'permissions']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $roleData = $request->except(['_token', 'permissions']);
        $role = Role::where('name', $request->name)->first();

        if($role && $role->id != $id) {
            return redirect()->back()->withInput()
                ->withErrors(['name' => __('messages.role.exists')]);
        }

        $role = Role::with('permissions')->find($id);

        $permissions = $role->permissions;
        $permissions = Permission::find($request->permissions);

        $role->syncPermissions($permissions);
        $role->update(['name' => $request->name]);

        setActionResponse('success', __('messages.role.updated'));
        return redirect()->route('role.store');
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        setActionResponse('success', __('messages.role.deleted'));
        return redirect()->route('role.store');
    }
}
