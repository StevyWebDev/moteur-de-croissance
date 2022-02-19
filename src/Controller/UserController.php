<?php

namespace App\Controller;

use App\Form\UpdateEmailType;
use App\Form\UpdatePasswordType;
use App\Repository\UserRepository;
use App\Service\UpdateUserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/user/update/firstname", name="update_firstname")
     */
    public function updateFirstname(UserInterface $userInterface, UserRepository $userRepository, EntityManagerInterface $manager, Request $request): Response {

        $updateUser = new UpdateUserService($userInterface, $userRepository, $manager);

        if($updateUser->updateUser($request->get('firstname'), 'firstname')) {
            return $this->redirectToRoute('profile_user');
        }
        else {
            return $this->render('user/form_update_account/updateFirstname.html.twig');
        }
    }

    /**
     * @Route("/user/update/name", name="update_name")
     */
    public function updateName(UserInterface $userInterface, UserRepository $userRepository, EntityManagerInterface $manager, Request $request): Response  {
        
        $updateUser = new UpdateUserService($userInterface, $userRepository, $manager);

        if($updateUser->updateUser($request->get('name'), 'name')) {
            return $this->redirectToRoute('profile_user');
        }
        else {
            return $this->render('user/form_update_account/updateName.html.twig');
        }
    }

    /**
     * @Route("/user/update/phone", name="update_phone")
     */
    public function updatePhone(UserInterface $userInterface, UserRepository $userRepository, EntityManagerInterface $manager, Request $request): Response  {
        
        $updateUser = new UpdateUserService($userInterface, $userRepository, $manager);

        if($updateUser->updateUser($request->get('phone'), 'phone')) {
            return $this->redirectToRoute('profile_user');
        }
        else {
            return $this->render('user/form_update_account/updatePhone.html.twig');
        }
    }

    /**
     * @Route("/user/update/email", name="update_email")
     */
    public function updateEmail(UserInterface $userInterface, UserRepository $userRepo, EntityManagerInterface $manager, Request $request): Response  {
        $form = $this->createForm(UpdateEmailType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $userRepo->findOneBy(['email' => $userInterface->getUsername()]);
            $user->setEmail($form->get('email')->getData());
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('account');
        }

        return $this->render('user/form_update_account/updateEmail.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/update/password", name="update_password")
     */
    public function updatePassword(UserInterface $userInterface, UserRepository $userRepo, EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response  {
        $form = $this->createForm(UpdatePasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($request->get('password')) {
                $pass = $request->get('password');
                if($passwordEncoder->isPasswordValid($userInterface, $pass)) {
                    $user = $userRepo->findOneByEmail($userInterface->getUsername());
                    $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
                    $manager->persist($user);
                    $manager->flush();
                }
                else {
                    $this->addFlash('error', 'Le mot de passe est incorrecte');
                }
            }

            return $this->redirectToRoute('account');
        }

        return $this->render('user/form_update_account/updatePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
