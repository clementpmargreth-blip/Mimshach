<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    /** @use HasFactory<\Database\Factories\AdmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'program',
        'year',
        'country',
        'deadline',
        'university_id',
    ];

    protected $casts = [
        'deadline' => 'date',
        'year' => 'date:Y',
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
