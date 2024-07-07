<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'occupation',
        'category',
        'source',
        'relationship',
        'status',
        'remarks',
        'is_deleted',
        'approach_date',
        'meeting_date',
        'followup_date',
        'processing_date',
        'submitted_date',
        'approved_date',
        'denied_date',
        'is_presenting',
        'medical_condition'


    ];
 
}
