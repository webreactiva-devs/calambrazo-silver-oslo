<?php

namespace App\Services;

use Jenssegers\Agent\Agent;
use App\Models\Vote;
use App\Contracts\VoteValidatorInterface;

class VoteDeviceService implements VoteValidatorInterface
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
    public function hasVoted(array $data): bool
    {
        $device = $data['device'];
        $feedbackId = $data['feedback_id'];
        $ip = $data['ip_address'];
        
        $result = Vote::where('device', $device)
            ->where('ip_address', $ip)
            ->where('feedback_id', $feedbackId)
            ->exists();

            return $result;
    }
}
