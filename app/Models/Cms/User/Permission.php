<?php

namespace App\Models\Cms\User;

use App\Models\BaseModel;

class Permission extends BaseModel
{
	protected $table = 'permissions';
    protected $fillable = ['name', 'created_by', 'updated_by'];
    public static $rules = array(
        'name' => 'required|unique:permissions'
    );
    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     *
     * Role list of a permission
     *
     */
    public function getRoleListAttribute(){
        return $this->roles->pluck('id')->all();
    }
}
