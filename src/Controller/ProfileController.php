<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyActivityRepository;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    /**
     * Affiche la vue de l'onglet "Information personnel" dans le dashboard profile.
     * @Route("/utilisateur", name="_user")
     */
    public function account(UserInterface $user): Response
    {
        return $this->render('profile/user_view.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Affiche la vue de l'onglet "Mon entreprise" dans le dashboard profile. Il permet de soit créer une entreprise si elle n'existe pas soit la fiche de l'entreprise si elle existe.
     * @Route("/entreprise", name="_company")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserInterface $userInterface, CompanyActivityRepository $companyActivities, CompanyRepository $companyRepo, UserRepository $userRepo): Response
    {
        //On récupère l'utilisateur par l'email de sa session
        $user = $userRepo->findOneByEmail($userInterface->getUsername());

        //On récupère sont entreprise par l'id de l'utilisateur
        $company = $companyRepo->findOneBy(['user' => $user->getId()]);

        //On verifie si une entreprise existe pour l'utilisateur courant. Si une entreprise existe, on rend la vue de la fiche entreprise
        if($company) {
            return $this->render('profile/company_view.html.twig', [
                'company' => $company
            ]);
        }
        else {
            //Si aucune entreprise existe, on créer un formulaire et on rend la vue du formulaire
            $company = new Company;
            $form = $this->createForm(CompanyType::class, $company);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                //upload image + inserer dans la bdd

                $picture = $form->get('logo')->getData();

                $ext = $picture->guessExtension();

                if(($ext == "jpg") || ($ext == "png") || ($ext == "bmp")) {

                    $namePicture = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                    $file = $namePicture . '_' . md5(uniqid()) . '.' . $picture->guessExtension();
                    $picture->move($this->getParameter('logo_directory'), $file);

                    $company->setLogo($file);
                }
                else {
                    throw $this->addFlash('error', 'Le format du logo doit être en jpg, png ou bmp');
                    return $this->redirectToRoute('profile_company');
                }

                $address = $form->get('adress')->getData();
                $address = explode(',', $address);
                $company->setAdress($address[0]);
                $company->addCompanyActivity($companyActivities->findOneBy(['id' => $form->get('companyActivities')->getData()]));
                $company->setUser($userInterface);
                $manager->persist($company);
                $manager->flush();
            }
            return $this->render('profile/company_create.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}
