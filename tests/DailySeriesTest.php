<?php

use ConVes\Recurrent\models\Event;
use ConVes\Recurrent\Recurrences\SeriesHelper;

class DailySeriesTest extends \PHPUnit_Framework_TestCase
{
    public function test_three_events_in_interval()
    {
        $event = (new Event)
            ->setStartDate('2016-01-01 00:00:00')
            ->setEndDate('2016-01-01 00:10:00')
            ->setRecurrenceType('daily')
            ->setRecurrenceStep(2);

        $seriesHelper = new SeriesHelper;

        $eventsInInterval = $seriesHelper->getEventSeriesBetween(
            $event,
            new \DateTime('2015-12-30'),
            new \DateTime('2016-01-07')
        );

        $this->assertCount(3, $eventsInInterval);
    }

    public function test_two_events_in_interval_because_event_finishes_at_date()
    {
        $event = (new Event)
            ->setStartDate('2016-01-01 00:00:00')
            ->setEndDate('2016-01-01 00:10:00')
            ->setSeriesEndDate('2016-01-04')
            ->setRecurrenceType('daily')
            ->setRecurrenceStep(2);

        $seriesHelper = new SeriesHelper;

        $eventsInInterval = $seriesHelper->getEventSeriesBetween(
            $event,
            new \DateTime('2015-12-30'),
            new \DateTime('2016-01-17')
        );

        $this->assertCount(2, $eventsInInterval);
    }

    public function test_two_events_in_interval_because_event_has_two_occurrences()
    {
        $event = (new Event)
            ->setStartDate('2016-01-01 00:00:00')
            ->setEndDate('2016-01-01 00:01:00')
            ->setOccurrences(2)
            ->setRecurrenceType('daily')
            ->setRecurrenceStep(2);

        $seriesHelper = new SeriesHelper;

        $eventsInInterval = $seriesHelper->getEventSeriesBetween(
            $event,
            new \DateTime('2015-12-30'),
            new \DateTime('2016-01-17')
        );

        $this->assertCount(2, $eventsInInterval);
    }
}