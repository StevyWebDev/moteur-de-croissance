<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UpdatePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/instription", name="register")
     */
    public function register(Request $request, TokenGeneratorInterface $tokenGenerator, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager, MailerInterface $mailer) {

        $user = new User;
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // On génère un token pour la validation de l'mail 
            $token = $tokenGenerator->generateToken();

            $user->setTokenValidation($token)
                 ->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            
            $manager->persist($user);
            $manager->flush();
            
            // On créer le mail de confiramtion
            $message = (new TemplatedEmail())
                ->from('no-reply@ebla.fr')
                ->to($user->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Validation de votre compte')
                ->htmlTemplate('email/validation.html.twig')
                ->context([
                    'token' => $user->getTokenValidation(),
                    'user' => $user->getName()
                ])
            ;

            // On envoi le mail de confirmation à l'utilisateur
            $mailer->send($message);

            return $this->redirectToRoute('home');
        }
        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Permet l'activation d'email de l'utilisateur
     * @Route("/activation/{token}", name="user_activation")
     */
    public function activation($token, UserRepository $userRepo, EntityManagerInterface $manager)
    {
        //On verifie si un utilisateur à ce token
        $user = $userRepo->findOneBy(['token_validation' => $token]);

        if(!$user)
        {
            throw $this->createNotFoundException('Cette utilisateur n\'existe pas !');
        }

        // On donne un role à l'utilisateur à l'activation de l'email
        $role[] = 'ROLE_USER_VALID';

        //On supprime le token à l'utilisateur
        $user->setTokenValidation(null);
        $user->setRoles($role);

        $manager->persist($user);
        $manager->flush();
        
        $this->addFlash('message', 'Vous avez bien activé votre compte'); 

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mot-de-passe-oublie", name="forgotPassword")
     */
    public function forgotPassword(Request $request, EntityManagerInterface $manager, UserRepository $userRepo, TokenGeneratorInterface $tokenGenerator, MailerInterface $mailer) {
        
        if($request->get('email')) {
            $email = strip_tags($request->get('email'));

            $user = $userRepo->findOneByEmail($email);

            if($user && $user->getTokenValidation() === null) {
                $token = $tokenGenerator->generateToken();
                $user->setTokenValidation($token);

                $manager->persist($user);
                $manager->flush();

                $message = (new TemplatedEmail())
                ->from('no-reply@ebla.fr')
                ->to($user->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Mot de passe oublié')
                ->htmlTemplate('email/forgotPassword.html.twig')
                ->context([
                    'token' => $user->getTokenValidation(),
                    'user' => $user->getName()
                ]);

                $mailer->send($message);
                
                return $this->redirectToRoute('home');
            }
            else {
                $this->addFlash('error', 'Votre email n\'existe pas ou n\'a pas encore été validé');
            }
            
        }
        return $this->render('security/forgotPassword.html.twig');
    }

    /**
     * @Route("/nouveau-mot-de-passe/{token}", name="updatePasswordForgot")
     */
    public function updatePasswordForgot(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager, $token, UserRepository $userRepo) {
        $form = $this->createForm(UpdatePasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $userRepo->findOneBy(['token_validation' => $token]);
            $user->setTokenValidation(null)
                 ->setPassword($passwordEncoder->encodePassword($user,$form->get('password')->getData()));
                    
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
            
        }
        return $this->render('security/updatePasswordForgot.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
