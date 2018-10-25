<?php

namespace App\Models;

use App\Models\Test;

use App\Models\Field;


class Product extends BaseModel
{
    protected $table = 'products';
    protected $fillable = ['title_tr', 'title_en', 'description_tr', 'description_en', 'main_image', 'created_by', 'updated_by'];
    public static $rules = array(
        'title_tr'=>'required|unique:products',
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
            'title_tr.required'=>'Ürün adı boş olamaz',
            'title_tr.unique'=>'Bu ürün adı daha önce kullanılmış',
            'description_tr.required'=>'Ürün açıklaması boş olamaz',
            'main_image.required'=>'Ürün ana resmi boş olamaz',
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

    public function tests(){
        return $this->belongsToMany('App\Models\Test');
    }

    public function fields(){
        return $this->belongsToMany('App\Models\Field');
    }

}