<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'image'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }
}
