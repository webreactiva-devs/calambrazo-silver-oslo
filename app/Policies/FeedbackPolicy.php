<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Feedback $feedback): bool
    {
        return $user->id === $feedback->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Feedback $feedback): bool
    {
        return $user->id === $feedback->user_id;
    }
}
