<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class WeeklyRecurrence extends Event implements RecurrenceInterface {
    
    protected $start;
    
    private $index;
    
    private $iteratingDate;
    
    private $daysOfWeek = [        
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    /**
     * WeeklyRecurrence constructor.
     *
     * @param date $start
     * @param int $index
     */
    public function __construct(
        $start,
        $index
    ) {
        $this->start = $start;
        $this->index = $index;
        $this->iteratingDate = clone $this->start;
    }
    
    public function getStartDate() 
    {       
        $index = 1;

        while ($index < $this->index) {
            $index++;
            $this->next();
        }
        
        return $this->iteratingDate;
    }
    
    public function getEndDate() 
    {
        $this->endDate = clone $this->iteratingDate;
        return $this->endDate->add(new \DateInterval('PT' . $this->getDurationInMinutes() . 'M'));
    }
    
    public function getIndex()
    {
        return $this->index;
    }
    
    private function next()
    {                         
        $nextWeekDay = $this->getNextWeekday();
        
        if ($nextWeekDay) {
                    
            $this->iteratingDate->modify($nextWeekDay.' this week');
            return;
        }         

        if (end($this->weekdays) == "Sunday") {
            // Hack for Sundays! It has something to do with the first day of
            // the week considered to be Sunday by PHP (ISO-8601) and Monday by our app.
            // Didn't have the time to investigate it just yet.
            // @todo Fix this!
            $this->iteratingDate->modify('Monday last week');
        }
        
        $this->iteratingDate->modify('+'.$this->getRecurrenceStep().' week');
        
        $firstWeekDay = $this->weekdays[0];
        
        $this->iteratingDate->modify($firstWeekDay.' this week');
        return;
    }
    
    /**
     * Get following day from the provided week days 
     * 
     * We're mapping days to our weekdays array and compare keys
     * 
     * @return mixed
     */
    private function getNextWeekday()            
    {   
        $currentDayOfWeek = date( "l", $this->iteratingDate->getTimestamp());

        $currentDayKey = array_search($currentDayOfWeek, $this->daysOfWeek);
        
        foreach ($this->weekdays as $weekday) {
            $comparedDayKey = array_search($weekday, $this->daysOfWeek);
            
            if ($comparedDayKey > $currentDayKey) {
                return $weekday;
            }
        }        
        return null;
    }    
}

