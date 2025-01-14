<?php

namespace App\Services;

use App\Models\Vote;
use App\Contracts\VoteValidatorInterface;

class VoteFingerprintService implements VoteValidatorInterface
{
    /**
     * Check if a fingerprint has already registered a vote.
     *
     * @param string $fingerprint
     * @param int $feedbackId
     * @return bool
     */
    public function hasVoted(array $data): bool
    {
        $fingerprint = $data['fingerprint'];
        $feedbackId = $data['feedback_id'];
        
        return Vote::where('feedback_id', $feedbackId)
            ->where('fingerprint', $fingerprint)
            ->exists();
    }
}
