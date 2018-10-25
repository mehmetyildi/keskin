<?php

namespace App\Models\Cms;

use App\Models\BaseModel;

class Task extends BaseModel
{
	protected $table = 'tasks';
    protected $fillable = ['description', 'isDone', 'position'];
}