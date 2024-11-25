<?php 

namespace App\Services;

use App\Models\Vote;

class VoteIpService
{
    /**
     * Comprueba si un feedback ha sido votado desde una IP específica.
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