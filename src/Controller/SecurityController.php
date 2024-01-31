<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;


class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
             'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
             'error'         => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route('/inscription', name:'inscription', methods: ['GET','POST'])]
    public function registration(MailerInterface $mailer, Request $request, EntityManagerInterface $em,VerifyEmailHelperInterface $verifyEmailHelper, EntityManagerInterface $manager): Response
    {   
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $user->setRoles(['ROLE_USER']);

            $this->addFlash(
                'success',
                'Votre compte à bien été créé! Vous allez reçevoir un email avec le lien pour confirmer votre adresse'
            );
            
            $manager->persist($user);
            $manager->flush();

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'verifications',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            $email = (new Email())
                -> from ('willempion@gmail')
                -> to($user->getEmail())
                -> subject('Inscription à geotools')
                -> text("Bonjour veuillez verifier votre compte ".$signatureComponents->getSignedUrl());

            $mailer->send($email);

            

            return $this->redirectToRoute('accueil');
        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/verifications', name:'verifications')]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
        {
            $user = $userRepository->find($request->query->get('id'));
            if (!$user) {
                throw $this->createNotFoundException();
            }
            try {
                $verifyEmailHelper->validateEmailConfirmation(
                    $request->getUri(),
                    $user->getId(),
                    $user->getEmail(),
                );
            }
             catch (VerifyEmailExceptionInterface $e) {
                $this->addFlash('error', $e->getReason());
                return $this->redirectToRoute('inscription');
            }
            $user->setIsVerified(true);
           
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte à été vérifier !');
            return $this->redirectToRoute('app_login');

       
    }
}
