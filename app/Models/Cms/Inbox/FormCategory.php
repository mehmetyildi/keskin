<?php

namespace App\Models\Cms\Inbox;

use App\Models\BaseModel;

class FormCategory extends BaseModel
{
    protected $table = 'form_categories';
    protected $fillable = ['title_tr', 'title_en', 'to', 'cc', 'contact_form_id', 'publish', 'created_by', 'updated_by'];
    public static $rules = array(
        'contact_form_id' => 'required',
        'title_tr' => 'required',
        'to' => 'required',
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

    /**
     * A form category belongs to a contact form
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(ContactForm::class, 'contact_form_id');
    }


    /**
     * A category may have many mails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mails()
    {
        return $this->hasMany(InboxMail::class, 'form_category_id');
    }

}