<?php

namespace App\Models;


class Video extends BaseModel
{
    protected $table = 'video';
    protected $fillable = ['title_tr', 'title_en', 'main_video_path', 'mobile_video_path', 'created_by', 'updated_by'];
    public static $rules = array(
    );
    public static $updaterules = array(
        'title_tr'=>'required'
    );

   

    public static function messages()
    {
        return[
            'title_tr.required'=>'Video adı boş olamaz',
        ];
    }

    public static $fields = array('title_tr', 'title_en', 'main_video_path', 'mobile_video_path');
    public static $imageFields = array(
       
    );
    public static $imageFieldNames = array(
      
    );
    public static $docFields = array(
    );
    public static $booleanFields = array(
    );
    public static $dateFields = array(
    );
    public static $urlFields = array(
    );

    public static function boot(){
        parent::boot();
        static::creating(function($model)
        {
           
            if($model->title_en == null){
                $model->title_en = $model->title_tr;
            }
        });
    }
}