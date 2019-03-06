<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Services\RoleManager;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Requests\Role\CreateRequest;

class RoleController extends Controller
{
    public function __construct(RoleManager $roleManager)
    {
        view()->share('page', 'role');
        $this->middleware('can:manage-roles');
        $this->roleManager = $roleManager;
    }

    public function store()
    {
        $roles = $this->roleManager->getAll();
        return view('role.store', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function save(CreateRequest $request)
    {
        $this->roleManager->create($request->name, $request->permissions);
        setActionResponse('success', 'The role has been successfully added!');
        return redirect()->route('role.store');
    }

    public function edit(Request $request, $id)
    {
        $role = $this->roleManager->getById($id);
        $permissions = $this->roleManager->getAllPermissions();

        return view('role.edit', compact(['role', 'permissions']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $role = $this->roleManager->getByName($request->name);

        if($role->isNotSelf($id)) {
            return redirect()->back()->withInput()
                ->withErrors(['name' => __('messages.role.exists')]);
        }

        $this->roleManager->update($id, $request->name, $request->permissions);

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
