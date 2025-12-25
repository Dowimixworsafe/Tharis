<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CalendarService;

final class CalendarController extends AbstractController
{
    #[Route('/calendar/{year?}/{month?}', name: 'app_calendar')]
    public function index(CalendarService $calendarService, Request $request, ?int $year = null, ?int $month = null): Response
    {
        $calendarData = $calendarService->getMonthView($year, $month);

        $isAjax = $request->headers->get('X-Requested-With') === 'XMLHttpRequest';

        if ($isAjax) {
            return $this->render('calendar/_calendar.html.twig', [
                'calendar' => $calendarData,
            ]);
        }

        return $this->render('calendar/index.html.twig', [
            'calendar' => $calendarData,
        ]);
    }
}
