<?php

use ConVes\Recurrent\Recurrences\RecurrenceFactory;
use ConVes\Recurrent\models\Event;

class RecurrenceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_instantiate_daily_recurrence()
    {
        $event = (new Event())
            ->setStartDate('2015-12-03')
            ->setEndDate('2015-12-03 00:10:00')
            ->setRecurrenceType('daily');

        $factory = new RecurrenceFactory();

        $dailyRecurrence = $factory->create(
            $event,
            1
        );

        $this->assertInstanceOf('ConVes\Recurrent\Recurrences\DailyRecurrence', $dailyRecurrence);
    }
}