<?php

use ConVes\Recurrent\models\Event;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function test_event_duration_in_minutes()
    {
        $event = (new Event)
            ->setStartDate('2016-01-01 00:00:00')
            ->setEndDate('2016-01-01 00:10:00')
            ->setRecurrenceType('daily')
            ->setRecurrenceStep(2);

        $this->assertEquals(10, $event->getDurationInMinutes());
    }
}