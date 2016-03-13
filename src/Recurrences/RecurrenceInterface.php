<?php

namespace ConVes\Recurrent\Recurrences;

/**
 * Description of RecurrenceInterface
 *
 * @author Corneliu.Vesa
 */

interface RecurrenceInterface {
    
    public function getStartDate();
    
    public function getEndDate();
    
    public function getIndex();
}


