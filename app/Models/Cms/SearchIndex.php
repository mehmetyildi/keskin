<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{
	protected $table = 'search_index';
    protected $fillable = ['keyword', 'folder', 'key'];

}