<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketSurvey extends Model
{
    use HasFactory;

    protected $table = 'market_survey';


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'saving_often',
        'savings_location',
        'critical_illness_level',
        'disabled_level',
        'force_retirement_level',
        'child_college_level',
        'money_protect',
        'contact_date',
        'questions',
        'name',
        'gender',
        'age',
        'phone_number',
        'civil_status',
        'occupation',
        'remarks',
        'is_deleted',
    ];
   

}
