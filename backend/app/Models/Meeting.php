<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'userId',
        'clientName',
        'age',
        'occupation',
        'medicalCondition',
        'status',
        'remarks',
        'active',
        'followupDate',
        'is_deleted'
    ];
   

}
