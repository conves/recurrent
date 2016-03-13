<?php

use ConVes\Recurrent\Recurrences\RecurrenceFactory;
use ConVes\Recurrent\models\Event;

class WeeklyRecurrenceTest extends \PHPUnit_Framework_TestCase
{
    private $recurrenceFactory;

    /**
     * Set private method accessible
     *
     * @param string $class
     * @param string $method
     * @return \ReflectionMethod
     */
    private function getMethod($class, $method)
    {
        $reflector = new \ReflectionClass($class);
        $method = $reflector->getMethod($method);
        $method->setAccessible( true );
        return $method;
    }

    public function setUp()
    {
        $this->recurrenceFactory = new RecurrenceFactory();
    }

    public function test_next_week_day_is_friday()
    {
        $event = (new Event())
            ->setStartDate('2015-12-03')
            ->setEndDate('2015-12-03 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'getNextWeekday'
        );

        $result = $result = $method->invokeArgs( $weekly, array());

        $this->assertEquals('Friday', $result);
    }

    public function test_next_day_in_the_same_week_is_null()
    {
        $event = (new Event())
            ->setStartDate('2015-12-04')
            ->setEndDate('2015-12-04 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'getNextWeekday'
        );

        $result = $result = $method->invokeArgs( $weekly, array());

        $this->assertEquals(null, $result);
    }

    public function test_no_day_remaining_in_this_week_go_next_week()
    {
        $event = (new Event())
            ->setStartDate('2015-12-04')
            ->setEndDate('2015-12-04 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'next'
        );

        $method->invokeArgs( $weekly, array());

        $this->assertEquals(
            \PHPUnit_Framework_Assert::readAttribute($weekly, 'iteratingDate'),
            new \DateTime('2015-12-07')
        );
    }

    public function test_no_day_remaining_in_this_week_go_two_weeks_ahead()
    {
        $event = (new Event())
            ->setStartDate('2015-12-04')
            ->setEndDate('2015-12-04 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(2)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'next'
        );

        $method->invokeArgs( $weekly, array());

        $this->assertEquals(
            \PHPUnit_Framework_Assert::readAttribute($weekly, 'iteratingDate'),
            new \DateTime('2015-12-14')
        );
    }

    public function test_same_week_go_to_next_day_from_array()
    {
        $event = (new Event())
            ->setStartDate('2015-12-03')
            ->setEndDate('2015-12-03 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'next'
        );

        $method->invokeArgs( $weekly, array());

        $this->assertEquals(
            \PHPUnit_Framework_Assert::readAttribute($weekly, 'iteratingDate'),
            new \DateTime('2015-12-04')
        );
    }

    public function test_same_week_go_to_next_day_from_array_2()
    {
        $event = (new Event())
            ->setStartDate('2015-12-07')
            ->setEndDate('2015-12-07 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            1
        );

        $method = $this->getMethod(
            'ConVes\Recurrent\Recurrences\WeeklyRecurrence',
            'next'
        );

        $method->invokeArgs( $weekly, array());

        $this->assertEquals(
            \PHPUnit_Framework_Assert::readAttribute($weekly, 'iteratingDate'),
            new \DateTime('2015-12-08')
        );
    }

    public function test_get_start_date_by_index_with_one_week_step()
    {
        $event = (new Event())
            ->setStartDate('2015-12-07')
            ->setEndDate('2015-12-07 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(1)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            3
        );

        $this->assertEquals(
            $weekly->getStartDate(),
            new \DateTime('2015-12-11')
        );
    }

    public function test_get_start_date_by_index_with_two_weeks_step()
    {
        $event = (new Event())
            ->setStartDate('2015-12-01')
            ->setEndDate('2015-12-04 00:10:00')
            ->setRecurrenceType('weekly')
            ->setRecurrenceStep(2)
            ->setWeekdays(['Monday', 'Tuesday', 'Friday']);

        $weekly = $this->recurrenceFactory->create(
            $event,
            5
        );

        $this->assertEquals(
            $weekly->getStartDate(),
            new \DateTime('2015-12-18')
        );
    }
}