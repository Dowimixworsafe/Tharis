<?php

namespace App\Service;

use App\Dto\CalendarMonthDTO;
use DateTimeImmutable;

class CalendarService
{
    public function getMonthView(?int $year, ?int $month): CalendarMonthDTO
    {
        $viewDate = ($year && $month) 
            ? new DateTimeImmutable("$year-$month-01") 
            : new DateTimeImmutable('first day of this month');

        $now = new DateTimeImmutable();
        $isCurrentMonth = ($viewDate->format('Y-m') === $now->format('Y-m'));

        $prevDate = $viewDate->modify('last month');
        $nextDate = $viewDate->modify('next month');
        
        $daysInMonth = $viewDate->format('t');
        $startDayOfWeek = $viewDate->format('N');
        $leadingEmptyDays = $startDayOfWeek - 1;

        $fillRestDays = (7 - (($leadingEmptyDays + $daysInMonth) % 7)) % 7;

        return new CalendarMonthDTO(
            year: (int)$viewDate->format('Y'),
            month: (int)$viewDate->format('n'),
            monthName: strtolower($viewDate->format('F')),
            daysInMonth: (int)$daysInMonth,
            leadingEmptyDays: (int)$leadingEmptyDays,
            fillRestDays: (int)$fillRestDays,
            currentDay: $isCurrentMonth ? (int)$now->format('j') : null,
            nextYear: (int)$nextDate->format('Y'),
            nextMonth: (int)$nextDate->format('n'),
            prevYear: (int)$prevDate->format('Y'),
            prevMonth: (int)$prevDate->format('n'),
        );
    }
}