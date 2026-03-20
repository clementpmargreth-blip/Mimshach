<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funding extends Model
{
    /** @use HasFactory<\Database\Factories\FundingFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'education_level',
        'university_id',
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
