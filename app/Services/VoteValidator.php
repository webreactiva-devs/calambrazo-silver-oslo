<?php

namespace App\Services;

class VoteValidator
{
    private $validators;

    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }

    public function validate(array $data)
    {
        foreach ($this->validators as $validator) {
            if ($validator->hasVoted($data)) {
                return false;
            }
        }

        return true;
    }
}