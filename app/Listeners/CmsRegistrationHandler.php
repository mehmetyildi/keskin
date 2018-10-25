<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use App\Models\Cms\User\Role;
use App\Models\Cms\User\Permission;
use App\Models\Cms\User\Setting;
use App\Models\Cms\User\PermissionRole;
use App\Models\Cms\User\RoleUser;
use App\Models\Cms\Loginlog;
use App\Models\Cms\User\Invitee;
use App\User;

class CmsRegistrationHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(User::all()->count() == 1){
            $role = Role::create(['name' => 'Architect', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            $permission = Permission::create(['name' => 'do_all', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            PermissionRole::create(['role_id' => $role->id, 'permission_id' => $permission->id]);
            RoleUser::create(['role_id' => $role->id, 'user_id' => $event->user->id]);

            Permission::create(['name' => 'compose_mail', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'create_content', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'create_form', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'create_form_category', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'delete_content', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'delete_form', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'delete_form_category', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'edit_content', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'edit_form', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'edit_form_category', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'manage_permissions', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'manage_roles', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'manage_users', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'view_forms', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'view_inbox', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Permission::create(['name' => 'view_user_management', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);

            Role::create(['name' => 'Admin', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Role::create(['name' => 'Mail Admin', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Role::create(['name' => 'Super Editor', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
            Role::create(['name' => 'Editor', 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);

            PermissionRole::create(['role_id' => 2, 'permission_id' => 3]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 5]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 6]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 8]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 9]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 10]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 11]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 14]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 15]);
            PermissionRole::create(['role_id' => 2, 'permission_id' => 17]);

            PermissionRole::create(['role_id' => 3, 'permission_id' => 2]);
            PermissionRole::create(['role_id' => 3, 'permission_id' => 16]);

            PermissionRole::create(['role_id' => 4, 'permission_id' => 3]);
            PermissionRole::create(['role_id' => 4, 'permission_id' => 6]);
            PermissionRole::create(['role_id' => 4, 'permission_id' => 9]);

            PermissionRole::create(['role_id' => 5, 'permission_id' => 9]);
	    }else{
	        $invitee = Invitee::where('email', $event->user->email)->first();
	        RoleUser::create(['role_id' => $invitee->role_id, 'user_id' => $event->user->id]);
	        $invitee->user_id = $event->user->id;
	        $invitee->save();
	    }
        $setting = Setting::create(['user_id' => $event->user->id, 'created_by' => $event->user->id, 'updated_by' => $event->user->id]);
        Loginlog::create(['user_id' => $event->user->id]);
    }
}
