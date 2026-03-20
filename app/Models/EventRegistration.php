<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
