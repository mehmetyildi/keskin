<?php

namespace App\Models\Articles;

use App\Models\BaseModel;

class Article extends BaseModel
{
    protected $table = 'articles';
    protected $fillable = ['title_tr', 'title_en', 'caption_tr', 'caption_en', 'description_tr', 'description_en', 'url_tr', 'url_en', 'video_path', 'main_image', 'promote', 'publish', 'position', 'actual_date', 'publish_at', 'publish_until', 'created_by', 'updated_by'];
    public static $rules = array(
        'title_tr' => 'required|unique:articles',
        'caption_tr' => 'required',
        'description_tr' => 'required',
    );
    public static $updaterules = array(
        'title_tr' => 'required',
        'caption_tr' => 'required',
        'description_tr' => 'required',
    );

     public static function messages()
    {
        return[
            'title_tr.required'=>'Haber adı boş olamaz',
            'title_tr.unique'=>'Bu haber adı daha önce kullanılmış',
            'description_tr.required'=>'Haber açıklaması boş olamaz',
            'caption_tr.required'=>'Haber özeti boş olamaz',
        ];
    }

    public static $fields = array('title_tr', 'title_en', 'caption_tr', 'caption_en', 'description_tr', 'description_en', 'video_path');
    public static $imageFields = array(
        ["name" => "main_image", "width" => 1200, "height" => 750, 'crop' => true, 'naming' => 'title_tr', 'diff' => ''] //1.6
    );
    public static $imageFieldNames = array(
        "main_image"
    );
    public static $docFields = array(
    );
    public static $booleanFields = array(
        'promote'
    );
    public static $dateFields = array(
        "publish_at", "publish_until", "actual_date"
    );
    public static $urlFields = array(
        ["name" => "url_tr", "map" => "title_tr"],
        ["name" => "url_en", "map" => "title_en"]
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
            if($model->caption_en == null){
                $model->caption_en = $model->caption_tr;
            }
            if($model->description_en == null){
                $model->description_en = $model->description_tr;
            }
            if($model->url_en == null){
                $model->url_en = $model->url_tr;
            }
        });
    }

    /**
     * An article may have many images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}