<?php

namespace App\Tests\Security;

use App\Entity\Student;
use App\Factory\StudentFactory;
use Zenstruck\Foundry\Test\Factories;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Zenstruck\Foundry\Test\ResetDatabase;

class LoginTest extends WebTestCase
{
    use ResetDatabase, Factories;

    public function test_login(): void
    {
        // Arrange
        $student = StudentFactory::new()->createOne(['email' => 'test@test.fr','password' => 'password']);

        // Act
        static::ensureKernelShutdown();
        $client = static::createClient();
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get('router');
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('app_login')
        );
        $client->submitForm('Se connecter', [
            'email' => $student->getEmail(),
            'password' => 'password'
        ]);

        // Assert
        self::assertResponseRedirects($urlGenerator->generate('app_home'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('app_home');
        $client->getCookieJar()->clear();
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function test_login_with_bad_credentials(): void
    {
        // Arrange
        $student = StudentFactory::new()->createOne(['email' => 'test@test.fr','password' => 'password']);

        // Act
        static::ensureKernelShutdown();
        $client = static::createClient();
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get('router');
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('app_login')
        );
        $client->submitForm('Se connecter', [
            'email' => $student->getEmail(),
            'password' => 'badpassword'
        ]);

        // Assert
        self::assertResponseRedirects($urlGenerator->generate('app_login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('app_login');
        $this->assertResponseIsSuccessful();

//        $this->assertSelectorTextContains('data-form-type', 'login');
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Invalid credentials.');
        $client->getCookieJar()->clear();
    }

//    public function test_logout(): void
//    {
//        // Given
//        $client = static::createClient();
//        /** @var UrlGeneratorInterface $urlGenerator */
//        $urlGenerator = $client->getContainer()->get('router');
//        $student = $this->logTheStudentIn($client, 'test@test.fr');
//
//        // When
//        $crawler = $client->request(
//            Request::METHOD_GET,
//            $urlGenerator->generate('app_logout')
//        );
//
//        // Then
//        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
//
//        $client->followRedirect();
//
//        $this->assertRouteSame('app_home');
//        $this->assertResponseIsSuccessful();
//        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
//        $client->getCookieJar()->clear();
//    }
//
//    private function logTheStudentIn(KernelBrowser $client, string $email): Student
//    {
//        $student = StudentFactory::new()->createOne(['email' => 'test@test.fr','password' => 'password']);
//        /** @var StudentRepository $studentRepository */
//        $studentRepository = static::getContainer()->get(StudentRepository::class);
//        /** @var Student $student */
//        $student = $studentRepository->findOneBy(['email' => $email]);
//        $client->loginUser($student);
//
//        return $student;
//    }
}
