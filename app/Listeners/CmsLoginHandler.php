<?php

namespace App\Listeners;

use App\Models\Cms\Loginlog;

class CmsLoginHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(auth()->user()->settings->isLocked){
            abort('423', auth()->user()->id);
        }
        Loginlog::create(['user_id' => auth()->user()->id]);
    }
}
