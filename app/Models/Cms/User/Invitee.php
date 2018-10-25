<?php

namespace App\Models\Cms\User;

use App\Models\BaseModel;
use App\User;

class Invitee extends BaseModel
{
    protected $table = 'invitees';
    protected $fillable = ['name', 'email', 'token', 'isRegistered', 'user_id', 'role_id', 'created_by', 'updated_by'];
    public static $rules = array(
        'name' => 'required|unique:invitees',
        'email' => 'required|unique:invitees',
    );

    /**
     * A user belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A user belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
