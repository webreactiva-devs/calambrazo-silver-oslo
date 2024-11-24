<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'feedback_id',
        'user_id',
        'ip_address',
        'device',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Vote::class);
    }
}
