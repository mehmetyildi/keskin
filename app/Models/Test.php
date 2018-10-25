<?php

namespace App\Models;

use App\Models\Product;

use App\Models\Field;



class Test extends BaseModel
{
    protected $table = 'tests';
    protected $fillable = ['title_tr', 'title_en', 'description_tr', 'description_en', 'main_image', 'video_path', 'created_by', 'updated_by'];
    public static $rules = array(
        'title_tr'=>'required|unique:tests',
        'description_tr'=>'required',
        'main_image'=>'required',
        'video_path'=>'required'

    );
    public static $updaterules = array(
        'title_tr'=>'required',
        'description_tr'=>'required',
        'video_path'=>'required'
    );
    public static function messages()
    {
        return[
            'title_tr.required'=>'Test adı boş olamaz',
            'title_tr.unique'=>'Bu test adı daha önce kullanılmış',
            'description_tr.required'=>'Test açıklaması boş olamaz',
            'video_path.required'=>'Test video alanı boş olamaz',
            'main_image.required'=>'Test ana resmi boş olamaz',
        ];
    }

    public static $fields = array('title_tr', 'title_en', 'video_path', 'description_tr', 'description_en');
    public static $imageFields = array(
        ["name" => "main_image", "width" => 700, "height" => 500, 'crop' => true, 'naming' => 'title_tr', 'diff' => ''] ,//1.4
        
    );
    public static $imageFieldNames = array(
        "main_image"
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

            if($model->description_en == null){
                $model->description_en = $model->description_tr;
            }
        });
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }

    public function fields(){
        return $this->hasManyThrough('App\Models\Field','App\Models\Product');
    }
}