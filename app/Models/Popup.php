<?php

namespace App\Models;


class Popup extends BaseModel
{
    protected $table = 'popups';
    protected $fillable = ['title_tr', 'title_en', 'image_path_tr', 'image_path_en', 'video_path', 'link', 'duration', 'publish', 'position', 'publish_at', 'publish_until', 'created_by', 'updated_by'];
    public static $rules = array(
    );
    public static $updaterules = array(
    );

    public static $fields = array('title_tr', 'title_en', 'video_path', 'link', 'duration');
    public static $imageFields = array(
        ["name" => "image_path_tr", "width" => 700, "height" => 500, 'crop' => true, 'naming' => 'title_tr', 'diff' => ''] ,//1.4
        ["name" => "image_path_en", "width" => 700, "height" => 500, 'crop' => true, 'naming' => 'title_tr', 'diff' => ''] //1.4
    );
    public static $imageFieldNames = array(
        "image_path_tr", "image_path_en"
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
            if($model->publish_at == null){
                $model->publish_at = todayWithFormat('Y-m-d');
            }
            if($model->title_en == null){
                $model->title_en = $model->title_tr;
            }
        });
    }
}