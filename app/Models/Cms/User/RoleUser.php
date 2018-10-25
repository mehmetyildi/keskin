<?php

namespace App\Models\Cms\User;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
	protected $table = 'role_user';
    protected $fillable = ['role_id', 'user_id'];


	public function role()
	{
		return $this->belongsTo(Role::class, 'role_id');
	}

}