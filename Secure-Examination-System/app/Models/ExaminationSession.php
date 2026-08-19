<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'session_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($session) {
            $session->answers()->delete();
        });
    }
}
