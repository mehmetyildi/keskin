<?php

namespace App\Http\Controllers\Cms\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\User\Role;
use App\Models\Cms\User\Invitee;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\User;

class UsersController extends BaseController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        checkPermissionFor('manage_users');
        $users = Invitee::all();
        return view('cms.user-management.users.index', compact('users'));
    }

    /**
     * Show the form for creating new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        checkPermissionFor('manage_users');
        $roles = Role::where('id', '!=', 1)->get();
        return view('cms.user-management.users.create', compact('roles'));
    }

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('manage_users');
        $this->validate($request, Invitee::$rules);
        $token = sha1(time());
        $invitee = new Invitee;
        $invitee->name = $request->name;
        $invitee->email = $request->email;
        $invitee->token = $token;
        $invitee->role_id = $request->role_id;
        $invitee->save();
        Mail::to($request->email)->send(new InvitationMail($request->name, $token));
        session()->flash('success', 'Kullanıcı davet edildi.');
        return redirect()->route('cms.user-management.users.index');
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        checkPermissionFor('manage_users');
        $roles = Role::where('id', '!=', 1)->pluck('name','id')->all();
        return view('cms.user-management.users.edit', compact('user', 'roles'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        checkPermissionFor('manage_users');
        $user->roles()->sync($request->role_list ?: []);
        $user->update($request->all());
        session()->flash('success', 'Rol güncellendi.');
        return redirect()->back();
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function ban(User $user)
    {
        checkPermissionFor('manage_users');
        $user->settings->isLocked = true;
        $user->settings->save();
        session()->flash('success', 'Kullanıcı engellendi.');
        return redirect()->back();
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivate(User $user)
    {
        checkPermissionFor('manage_users');
        $user->settings->isLocked = false;
        $user->settings->save();
        session()->flash('success', 'Kullanıcının engeli kaldırıldı.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Invitee $invitee)
    {
        checkPermissionFor('manage_users');
        $invitee->delete();
        session()->flash('success', 'Kullanıcı silindi.');
        return redirect()->route('cms.user-management.users.index');
    }
}
