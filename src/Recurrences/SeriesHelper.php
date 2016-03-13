<?php

namespace ConVes\Recurrent\Recurrences;

use ConVes\Recurrent\models\Event;

class SeriesHelper {
    
    private $seriesFactory;

    public function __construct()
    {
        $this->seriesFactory = new SeriesFactory;
    }

    /**
     * @param Event $event
     * @param \DateTime $start
     * @param \DateTime $end
     * @return int
     */
    public function getSeriesDurationInMinutes(
        Event $event,
        \DateTime $start,
        \DateTime $end
    ) {      
        $totalDuration = 0;

        $series = $this->getEventSeriesBetween($event, $start, $end);

        $eventStartDate = $event->getStartDate();
        $eventEndDate= $event->getEndDate();
        
        foreach ($series as $event) {
            if ($eventStartDate <= $end && $eventEndDate >= $start) {
                $totalDuration += $event->getDurationInMinutes();
            }
        }
        
        return $totalDuration;
    }
    
    
    /**
     * @todo A bit too complex. May need some refactoring.
     *
     * @param Event $event
     * @param \DateTime $intervalStart
     * @param \DateTime $intervalEnd
     * @return array
     */
    public function getEventSeriesBetween(
        Event $event,
        \DateTime $intervalStart,
        \DateTime $intervalEnd
    ) {
        $eventSeriesEndDate = $event->getSeriesEndDate();

        // If the maximum number of occurrences is set, we're decrementing it by 1,
        // because we're going to firstly push into the series the event itself
        $eventOccurrences = $event->getOccurrences() ? $event->getOccurrences() - 1 : null;

        // Push into the array the event itself, as the first occurrence
        $seriesOfEvents[] = $event;

        $series = $this->seriesFactory->create($event);

        do {
            $series->next();
            $currentOccurrence = $series->getCurrentOccurrence();

            $occurrenceStart = $currentOccurrence->getStartDate();
            $occurrenceEnd = $currentOccurrence->getEndDate();
            $occurrenceIndex = $currentOccurrence->getIndex();

            if ($eventSeriesEndDate && $occurrenceStart >= $eventSeriesEndDate) {
                // Case B: event with series end specified & the current occurrence
                // is already equal with or after the series end (this is the last loop)
                continue;
            }

            if (
                $occurrenceStart < $intervalEnd &&
                $occurrenceEnd > $intervalStart
            ) {
                // Occurrence overlap the interval, so we're pushing it into array
                $seriesOfEvents[] = $currentOccurrence;
            }

        } while (
            $occurrenceStart < $intervalEnd &&
            (
                // Case A: never ending event
                ( ! $eventSeriesEndDate && ! $eventOccurrences) ||
                // Case B: event with series end specified
                ($eventSeriesEndDate && $occurrenceStart < $eventSeriesEndDate) ||
                // Case C: event with no of occurrences specified
                ($eventOccurrences && $occurrenceIndex < $eventOccurrences)
            )
        );
        
        return $seriesOfEvents;
    }
}
