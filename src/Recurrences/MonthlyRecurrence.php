<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class MonthlyRecurrence extends Event implements RecurrenceInterface {
    
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
        $monthsFromStart = $this->index * $this->getRecurrenceStep();
        $this->startDate = clone $this->start;       
        
        $this->startDate->add(new \DateInterval('P' . $monthsFromStart . 'M'));
        
        if ($this->getRepeatOnMonthday()) {
            return $this->startDate; 
        }        
        
        if ($this->getRepeatOnWeekday()) {
            // @todo Implement repeating rule for day of the week
            return $this->startDate;
        }
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
