<?php

namespace App\Controller;

use App\Entity\DrivingSessionBooking;
use App\Entity\Student;
use App\Form\DrivingSessionBookingType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DrivingSessionBookingController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }


    #[Route('/driving-session/book', name: 'app_driving-session_book')]
    #[isGranted('ROLE_STUDENT', message: 'Vous devez être connecté en tant qu\'élève pour accéder à cette page.')]
    public function book(Request $request): Response
    {
        $drivingSession = new DrivingSessionBooking();

        $form = $this->createForm(DrivingSessionBookingType::class, $drivingSession);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Student $student */
            $student = $this->getUser();
            $drivingSession->setStudent($student);
            $drivingSession->setInstructor($student->getAssignedInstructor());
            $drivingSession->setStatus(DrivingSessionBooking::STATUS_BOOKED);
            $drivingSession->setDate($form->get('date')->getData());
            $drivingSession->setTime($form->get('time')->getData());

            try {
                $this->entityManager->persist($drivingSession);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }

            $this->addFlash('success', 'Votre séance a bien été réservée.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('driving-session/book.html.twig', [
            'drivingSessionBookingForm' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }
}
