<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function examinationSessions()
    {
        return $this->hasMany(ExaminationSession::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($examination) {
            $examination->questions()->delete();
            $examination->examinationSessions()->delete();
            $examination->results()->delete();
        });
    }
}
