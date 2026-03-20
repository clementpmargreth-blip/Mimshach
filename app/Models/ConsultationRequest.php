<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'level_of_education',
        'programme_of_interest',
        'preferred_countries',
        'tuition_budget'
    ];

    protected $casts = [
        'programme_of_interest' => 'array',
        'preferred_countries' => 'array',
    ];
}
