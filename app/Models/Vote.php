<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'feedback_id',
        'user_id',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Vote::class);
    }
}
