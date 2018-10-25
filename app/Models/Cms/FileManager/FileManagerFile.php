<?php

namespace App\Models\Cms\FileManager;

use App\Models\BaseModel;


class FileManagerFile extends BaseModel
{
    protected $table = 'file_manager_files';
    protected $fillable = ['file_manager_category_id', 'title', 'file_path', 'created_by', 'updated_by'];
    public static $rules = array(
        'file_manager_category_id' => 'required',
    );
    public static $updaterules = array(
        'file_manager_category_id' => 'required',
    );

    public static $fields = array('file_manager_category_id', 'title');
    public static $imageFields = array(
    );
    public static $imageFieldNames = array(
    );
    public static $docFields = array(
    	"file_path"
    );
    public static $dateFields = array(
    );


    /**
     * A file belongs to a category under file manager
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo(FileManagerCategory::class, 'file_manager_category_id');
    }

}