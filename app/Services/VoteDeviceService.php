<?php

namespace App\Services;

use Jenssegers\Agent\Agent;
use App\Models\Vote;

class VoteDeviceService
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Detecta el dispositivo.
     *
     * @return string
     */
    public function detectDevice(): string
    {
        $device = $this->agent->device();
        

        return $device;
    }

    /**
     * Comprobar si un dispositivo ya ha registrado un voto
     * con una IP y dispositivo determinado.
     *
     * @param string $device
     * @param string $ip
     * @param int $feedbackId
     * @return bool
     */
    public function hasVotedWithDevice(string $device, int $feedbackId, string $ip): bool
    {
        $result = Vote::where('device', $device)
            ->where('ip_address', $ip)
            ->where('feedback_id', $feedbackId)
            ->exists();

            return $result;
    }
}
