<?php

namespace ConVes\Recurrent\models;

use ConVes\Recurrent\Recurrences\AllowedReccurrenceTypes;
use ConVes\Recurrent\Recurrences\RecurrenceInterface;

class Event
{
    protected $title;

    protected $description;

    protected $startDate;

    protected $endDate;

    protected $recurrenceType;

    protected $recurrenceStep;

    protected $occurrences;

    protected $seriesEndDate;

    protected $weekdays;

    protected $repeatOnWeekday;

    protected $repeatOnMonthday;

    public function setStartDate($string)
    {
        $this->startDate = (new \DateTime)->setTimestamp(strtotime($string));

        if ( ! $this->startDate instanceof \DateTime) {
            throw new \Exception("Invalid start time string provided.");
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate($string)
    {
        $this->endDate = (new \DateTime)->setTimestamp(strtotime($string));

        if ( ! $this->startDate instanceof \DateTime) {
            throw new \Exception("Invalid end time string provided.");
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getDurationInMinutes()
    {
        $difference = $this->startDate->diff($this->endDate);
        $minutes = $difference->days * 24 * 60 + $difference->h * 60 + $difference->i;
        return (int)$minutes;
    }

    /**
     * @param string $type
     * @throws \Exception
     * @return $this
     */
    public function setRecurrenceType($type)
    {
        if ( ! (new AllowedReccurrenceTypes())->contains($type)) {
            throw new \Exception("Recurrence type {$type} not allowed!");
        }
        $this->recurrenceType = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecurrenceType()
    {
        return $this->recurrenceType;
    }

    /**
     * @param int $step
     * @return $this
     */
    public function setRecurrenceStep($step)
    {
        $this->recurrenceStep = (int)$step;

        return $this;
    }

    /**
     * @return int
     */
    public function getRecurrenceStep()
    {
        return $this->recurrenceStep;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setOccurrences($number)
    {
        $this->occurrences = (int)$number;

        return $this;
    }

    /**
     * @return int
     */
    public function getOccurrences()
    {
        return $this->occurrences;
    }

    /**
     * @param $string
     * @return $this
     * @throws \Exception
     */
    public function setSeriesEndDate($string)
    {
        $this->seriesEndDate = (new \DateTime)->setTimestamp(strtotime($string));

        if ( ! $this->seriesEndDate instanceof \DateTime) {
            throw new \Exception("Invalid series end date string provided.");
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSeriesEndDate()
    {
        return $this->seriesEndDate;
    }

    /**
     * @param array $weekdays
     * @return $this
     */
    public function setWeekdays(array $weekdays)
    {
        $this->weekdays = $weekdays;

        return $this;
    }

    /**
     * @return array
     */
    public function getWeekdays()
    {
        return is_array($this->weekdays) ? $this->weekdays : [];
    }

    /**
     * @param $weekday
     * @return $this
     */
    public function setRepeatOnWeekday($weekday)
    {
        $this->repeatOnWeekday = $weekday;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepeatOnWeekday()
    {
        return $this->repeatOnWeekday;
    }

    /**
     * @param int $monthday
     * @return $this
     */
    public function setRepeatOnMonthday($monthday)
    {
        $this->repeatOnMonthday = $monthday;

        return $this;
    }

    /**
     * @return int
     */
    public function getRepeatOnMonthday()
    {
        return $this->repeatOnMonthday;
    }

    /**
     * Export properties of this initial event to one of its occurrences
     *
     * @param RecurrenceInterface $instance
     */
    public function exportPropertiesTo(RecurrenceInterface $instance)
    {
        foreach (get_object_vars($this) as $key => $value) {
            $instance->$key = $value;
        }
    }
}