<?php

namespace ConVes\Recurrent\Recurrences;

class AllowedReccurrenceTypes {

    private $allowedTypes = [
        'daily',
        'weekly',
        'monthly',
        'yearly'
    ];

    /**
     * @param string $type
     * @return bool
     */
    public function contains($type)
    {
        return in_array($type, $this->allowedTypes);
    }
}