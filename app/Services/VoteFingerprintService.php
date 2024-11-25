<?php

namespace App\Services;

use App\Models\Vote;

class VoteFingerprintService
{
    /**
     * Verificar si el fingerprint ya ha votado para un ítem específico.
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
