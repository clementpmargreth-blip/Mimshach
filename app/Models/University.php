<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /** @use HasFactory<\Database\Factories\UniversityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'image',
        'country',
        'city',
        'logo',
    ];

    public function fundings()
    {
        return $this->hasMany(Funding::class, 'university_id');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'university_id');
    }
}
