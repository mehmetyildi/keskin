<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class BaseModel extends Model{
  
    public static function boot(){
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            if($user){
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }          
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            if($user){
                $model->updated_by = $user->id;
            }
        });      
    }

    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
  
}
