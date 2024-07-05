<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'fullname',
        'agent_code',
        'position',
        'title',
        'date_coded',
        'phone',
        'company',
        'subscription',
        'is_deleted',
        
    ];
   
}
