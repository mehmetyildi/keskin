<?php

namespace App\Models;

use App\Models\Test;

use App\Models\Product;


class Field extends BaseModel
{
    protected $table = 'fields';
    protected $fillable = ['title_tr', 'title_en', 'description_tr', 'description_en', 'main_image', 'created_by', 'updated_by'];
    public static $rules = array(
        'title_tr'=>'required|unique:fields',
        'description_tr'=>'required',
        'main_image'=>'required'

    );
    public static $updaterules = array(
        'title_tr'=>'required',
        'description_tr'=>'required'
    );
    public static function messages()
    {
        return[
            'title_tr.required'=>'Uygulama alanı adı boş olamaz',
            'title_tr.unique'=>'Bu uygulama alanı adı daha önce kullanılmış',
            'description_tr.required'=>'Uygulama alanı açıklaması boş olamaz',
            'main_image.required'=>'Uygulama alanı ana resmi boş olamaz',
        ];
    }

    public static $fields = array('title_tr', 'title_en', 'description_tr', 'description_en');
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

    public function tests(){
        return $this->hasManyThrough('App\Models\Test','App\Models\Product');
    }

}