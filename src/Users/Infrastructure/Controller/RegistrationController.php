<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\EmailVerifier;
use App\Users\Infrastructure\Form\LoginFormType;
use App\Users\Infrastructure\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    private UserPasswordHasher $hasher;

    public function __construct(EmailVerifier $emailVerifier, UserPasswordHasher $hasher)
    {
        $this->emailVerifier = $emailVerifier;
        $this->hasher = $hasher;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

    #[Route('/login', name: 'app_login')]
#    #[Template('user/login.html.twig')]
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $error = $authUtils->getLastAuthenticationError();
        if ($form->isSubmitted()) {
            $email = $request->get('email');
            $password = $request->get('password');
            die(var_export([$email, $password]));
            $this->hasher->isPasswordValid($user, $password);

            return $this->redirectToRoute('home');
        }

        return $this->render('user/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $error
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}