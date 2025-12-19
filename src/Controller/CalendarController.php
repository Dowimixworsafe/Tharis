<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(): Response
    {
        $today = new \DateTimeImmutable();
        
        $daysInMonth = (int) $today->format('t');

        $firstDayOfMonth = $today->modify('first day of this month');
        $startDayOfWeek = (int) $firstDayOfMonth->format('N');

        return $this->render('calendar/index.html.twig', [
            'daysInMonth' => $daysInMonth,
            'firstDayOfMonth' => $firstDayOfMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'currentDay' => (int) $today->format('j'),
        ]);
    }
}
