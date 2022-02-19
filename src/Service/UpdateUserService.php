<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class UpdateUserService {
    private UserInterface $userInterface;
    private UserRepository $userRepository;
    private EntityManagerInterface $manager;

    public function __construct(UserInterface $userInterface, UserRepository $userRepository, EntityManagerInterface $manager) {
        $this->userInterface = $userInterface;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }

    public function updateUser($request, $type): bool {
        if($request && !empty($request)) {
            $userData = strip_tags($request);

            $user = $this->userRepository->findOneBy((['email' => $this->userInterface->getUsername()]));
            switch ($type) {
                case 'firstname':
                    $user->setFirstname($userData);
                    break;
                
                case 'name':
                    $user->setName($userData);
                    break;

                case 'phone':
                    $user->setPhone($userData);
                    break;
            }
            

            $this->manager->persist($user);
            $this->manager->flush();

            return true;
        }
        else {
            return false;
        }
    }
}