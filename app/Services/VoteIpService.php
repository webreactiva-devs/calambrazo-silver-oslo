<?php 

namespace App\Services;

use App\Models\Vote;

class VoteIpService
{
    /**
     * Check if a vote has already been registered with a specific IP.
     *
     * @param int $feedbackId
     * @param string $ipAddress
     * @return bool
     */
    public function hasVotedWithIp(int $feedbackId, string $ipAddress): bool
    {
        return Vote::where('feedback_id', $feedbackId)
            ->where('ip_address', $ipAddress)
            ->exists();
    }
}