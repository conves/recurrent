<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class YearlyRecurrence extends Event implements RecurrenceInterface {
    
    private $start;
    
    private $index;
    
    public function __construct(
        $start,
        $index
    ) {
        $this->start = $start;
        $this->index = $index;
    }
    public function getStartDate() 
    {
        $yearsFromStart = $this->index * $this->getRecurrenceStep();
        $this->startDate = clone $this->start;
        return $this->startDate->add(new \DateInterval('P' . $yearsFromStart . 'Y'));
    }
    
    public function getEndDate() 
    {
        $this->endDate = clone $this->startDate;
        return $this->endDate->add(new \DateInterval('PT' . $this->getDurationInMinutes() . 'M'));
    }
    
    public function getIndex()
    {
        return $this->index;
    }  
}

