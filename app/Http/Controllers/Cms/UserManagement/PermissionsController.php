<?php

namespace App\Http\Controllers\Cms\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\User\Permission;

class PermissionsController extends BaseController
{
    /**
     * PermissionsController constructor.
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
        checkPermissionFor('manage_permissions');
        $permissions = Permission::all();
        return view('cms.user-management.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        checkPermissionFor('manage_permissions');
        return view('cms.user-management.permissions.create');
    }

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('manage_permissions');
        $this->validate($request, Permission::$rules);
        Permission::create($request->all());
        session()->flash('success', 'Yeni yetki oluşturuldu.');
        return redirect()->route('cms.user-management.permissions.index');
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        checkPermissionFor('manage_permissions');
        return view('cms.user-management.permissions.edit', compact('permission'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        checkPermissionFor('manage_permissions');
        $permission->update($request->all());
        session()->flash('success', 'Yetki güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Permission $permission)
    {
        checkPermissionFor('manage_permissions');
        $permission->delete();
        session()->flash('success', 'Yetki silindi.');
        return redirect()->route('cms.user-management.permissions.index');
    }

}
