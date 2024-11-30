<?php

namespace App\Services;

use App\Models\Vote;

class VoteFingerprintService
{
    /**
     * Check if a fingerprint has already registered a vote.
     *
     * @param string $fingerprint
     * @param int $feedbackId
     * @return bool
     */
    public function hasVotedWithFingerprint(string $fingerprint, int $feedbackId): bool
    {
        return Vote::where('feedback_id', $feedbackId)
            ->where('fingerprint', $fingerprint)
            ->exists();
    }
}
