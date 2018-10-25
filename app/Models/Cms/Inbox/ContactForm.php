<?php

namespace App\Models\Cms\Inbox;

use App\Models\BaseModel;

class ContactForm extends BaseModel
{
    protected $table = 'contact_forms';
    protected $fillable = ['title', 'to', 'cc', 'created_by', 'updated_by'];
    public static $rules = array(
        'title' => 'required|unique:contact_forms',
        'to' => 'required',
    );
    public static $updaterules = array(
        'title' => 'required',
        'to' => 'required',
    );

    /**
     * A form may have many categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(FormCategory::class, 'contact_form_id');
    }


    /**
     * A form may have many mails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mails()
    {
        return $this->hasMany(InboxMail::class, 'contact_form_id');
    }

}