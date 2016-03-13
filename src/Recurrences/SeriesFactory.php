<?php

namespace ConVes\Recurrent\Recurrences;

class SeriesFactory {
    
    public function create($event)
    {    
        $recurrenceFactory = new RecurrenceFactory;
        
        $series = new Series(
            $event,
            $recurrenceFactory      
        );
        
        return $series;
    }   
}

