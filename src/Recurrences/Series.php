<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class Series {

    private $event;
    
    private $recurrenceFactory;
    
    private $type;
    
    private $seriesIndex = 0;
    
    private $currentOccurrence = null;  
    
    private $previousOccurrence = null;
    
    /**
     * @param Event $event
     * @param RecurrenceFactory $recurrenceFactory
     */
    public function __construct(
        Event $event,
        RecurrenceFactory $recurrenceFactory
    ) {
        $this->event = $event;

        $this->recurrenceFactory = $recurrenceFactory;

        $this->type = $event->getRecurrenceType();
    }  

    
    public function getIndex()
    {
        return $this->seriesIndex;
    }
    
    public function incrementIndex()
    {
        $this->seriesIndex = $this->seriesIndex + 1;
        return $this;
    }

    public function setCurrentOccurrence($occurrence)
    {
        $this->currentOccurrence = $occurrence;
        return $this;
    }

    public function getCurrentOccurrence()
    {
        return $this->currentOccurrence;
    }

    /**
     * Just in case we're going to need it
     *
     * @param $occurrence
     * @return $this
     */
    public function setPreviousOccurrence($occurrence)
    {
        $this->previousOccurrence = $occurrence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreviousOccurrence()
    {
        return $this->previousOccurrence;
    }
    
    /**
     * Walk through recurrences up until reaching the provided index
     * 
     * @param integer $index
     * @return RecurrenceInterface
     */
    public function getOccurrence(
        $index
    ) {
        while ($this->getIndex() < $index) {
            $this->next();
        }        
        return $this->getCurrentOccurrence();
    }
   
    /**
     * Iterator
     *
     * Go to next occurrence and set it as current
     */
    public function next() 
    {
        $this->setPreviousOccurrence(
            $this->getCurrentOccurrence()
        );
        $this->incrementIndex();
        $occurrence = $this->recurrenceFactory->create(
            $this->event,
            $this->getIndex()
        );     
        $this->setCurrentOccurrence($occurrence);
        return $this;
    }    
}

