<?php

namespace App\Contracts;

interface VoteValidatorInterface
{
    public function hasVoted(array $data): bool;
}