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
     * Detect the device of the user.
     *
     * @return string
     */
    public function detectDevice(): string
    {
        $device = $this->agent->device();
        

        return $device;
    }

    /**
     * Check if a device has already registered a vote
     * with a specific IP and device.
     *
     * @param string $device The device identifier.
     * @param int $feedbackId The feedback identifier.
     * @param string $ip The IP address of the device.
     * @return bool True if the device has already voted, false otherwise.
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
