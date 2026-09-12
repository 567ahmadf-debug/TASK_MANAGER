<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles' ; 
    protected $fillable = [
            'user_id' , 
            'phone' ,
            'address', 
            'date_of_birth' ,
            'bio' , 
            'image'
        ] ; 

    
    public function user (){
        return $this->belongsTo(User::class) ; 
    }
}
