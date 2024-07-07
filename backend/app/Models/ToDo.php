<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'task_name',
        'urgency',
        'status'

    ];
}
