<?php

namespace App\Http\Controllers\Cms\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\User\Role;
use App\Models\Cms\User\Permission;

class RolesController extends BaseController
{
    /**
     * RolesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        checkPermissionFor('manage_roles');
        $roles = Role::all();
        return view('cms.user-management.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        checkPermissionFor('manage_roles');
        return view('cms.user-management.roles.create');
    }

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('manage_roles');
        $this->validate($request, Role::$rules);
        Role::create($request->all());
        session()->flash('success', 'Yeni rol oluşturuldu.');
        return redirect()->route('cms.user-management.roles.index');
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        checkPermissionFor('manage_roles');
        $permissions = Permission::pluck('name','id')->all();
        return view('cms.user-management.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        checkPermissionFor('manage_roles');
        $role->permissions()->sync($request->permission_list ?: []);
        $role->update($request->all());
        session()->flash('success', 'Rol güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Role $role)
    {
        checkPermissionFor('manage_roles');
        $role->delete();
        session()->flash('success', 'Rol silindi.');
        return redirect()->route('cms.user-management.roles.index');
    }

}
