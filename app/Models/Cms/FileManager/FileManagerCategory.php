<?php

namespace App\Models\Cms\FileManager;

use App\Models\BaseModel;

class FileManagerCategory extends BaseModel
{
    protected $table = 'file_manager_categories';
    protected $fillable = ['title', 'created_by', 'updated_by'];
    public static $rules = array(
        'title' => 'required|unique:file_manager_categories',
    );
    public static $updaterules = array(
        'title' => 'required',
    );

    public static $fields = array('title');
    public static $imageFields = array(
    );
    public static $imageFieldNames = array(
    );
    public static $docFields = array(
    );
    public static $dateFields = array(
    );


    /**
     * A file category may have many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function files()
    {
        return $this->hasMany(FileManagerFile::class, 'file_manager_category_id');
    }


}