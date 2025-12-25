<?php

namespace App\Dto;

final readonly class CalendarMonthDTO
{
    public function __construct(
        public int $year,
        public int $month,
        public string $monthName,
        public int $daysInMonth,
        public int $leadingEmptyDays,
        public int $fillRestDays,
        public ?int $currentDay,
        public int $nextYear,
        public int $nextMonth,
        public int $prevYear,
        public int $prevMonth,
    ) {}
}