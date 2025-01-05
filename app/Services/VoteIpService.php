<?php 

namespace App\Services;

use App\Models\Vote;
use App\Contracts\VoteValidatorInterface;

class VoteIpService implements VoteValidatorInterface
{
    /**
     * Check if a vote has already been registered with a specific IP.
     *
     * @param int $feedbackId
     * @param string $ipAddress
     * @return bool
     */
    public function hasVoted(array $data): bool
    {
        $feedbackId = $data['feedback_id'];
        $ipAddress = $data['ip_address'];

        return Vote::where('feedback_id', $feedbackId)
            ->where('ip_address', $ipAddress)
            ->exists();
    }
}