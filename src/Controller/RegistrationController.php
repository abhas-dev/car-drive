<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(RegistrationFormType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->setPassword(
                $passwordHasher->hashPassword($student,$form->get('plainPassword')->getData())
            );
            $student->setName($form->get('name')->getData());
            $student->setFirstname($form->get('firstname')->getData());
            $student->setPhone($form->get('phone')->getData());
            $student->setRegisteredAt(new \DateTimeImmutable());
            $student->setRoles(['ROLE_STUDENT']);
            if($form->get('agreeTerms')->getData()){
                $student->agreeTerms();
            }
            // TODO: set isVerified to false
            $student->setIsVerified(true);


            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été enregistré. Veuillez confirmer votre adresse en cliquant sur lien dans le mail reçu."
            );

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $student,
                (new TemplatedEmail())
                    ->from(new Address('mailer@car-drive.fr', 'Car Drive Bot'))
                    ->to($student->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Votre compte a bien été enregistré. Veuillez confirmer votre adresse en cliquant sur lien dans le mail reçu.'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());

        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
