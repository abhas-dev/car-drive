<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrivingSessionBookingController extends AbstractController
{
    #[Route('/driving/session/booking', name: 'app_driving_session_booking')]
    public function index(): Response
    {
        return $this->render('driving_session_booking/index.html.twig', [
            'controller_name' => 'DrivingSessionBookingController',
        ]);
    }
}
