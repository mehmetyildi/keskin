<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Loginlog extends Model
{
	protected $table = 'loginlogs';
    protected $fillable = ['user_id'];

    /**
     * A user belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}