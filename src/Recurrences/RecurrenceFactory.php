<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class RecurrenceFactory {

    /**
     * Instantiate a new occurrence
     *
     * @param Event $event
     * @param int $index
     * @return mixed
     * @throws \Exception
     */
    public function create(
        Event $event,
        $index
    ) {
        $path = 'ConVes\Recurrent\Recurrences\\';
        $class = $path . ucwords(strtolower($event->getRecurrenceType()))."Recurrence";
        if (class_exists($class)) {
            $instance = new $class($event->getStartDate(), $index);

            $event->exportPropertiesTo($instance);

            return $instance;
            
        } else {
            throw new \Exception("Invalid recurrence type given.");
        } 
    }
}

