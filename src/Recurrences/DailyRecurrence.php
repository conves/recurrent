<?php
namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class DailyRecurrence extends Event implements RecurrenceInterface {
    
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
        $daysFromStart = $this->index * $this->getRecurrenceStep();
        
        $this->startDate = clone $this->start;
        $this->startDate->add(new \DateInterval('P' . $daysFromStart . 'D'));
        return $this->startDate;
    }
    
    public function getEndDate() 
    {
        $endDate = clone $this->startDate;
        $endDate->add(new \DateInterval('PT' . $this->getDurationInMinutes() . 'M'));
        return $endDate;
    }
    
    public function getIndex()
    {
        return $this->index;
    } 
}
