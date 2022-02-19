<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyNotice;
use App\Form\CompanyNoticeFormType;
use App\Repository\CompanyNoticeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/company", name="company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/information/{company}", name="_information")
     */
    public function company_information(Company $company, Request $request, EntityManagerInterface $manager, UserInterface $userInterface = null, CompanyNoticeRepository $companyNoticeRepository) {
        $companyNotice = new CompanyNotice;
        $form =$this->createForm(CompanyNoticeFormType::class, $companyNotice);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $companyNotice->setCreatedAt(new \DateTime('now'))
                ->setUser($userInterface)
                ->setCompany($company)
            ;

            $manager->persist($companyNotice);
            $manager->flush();

            return $this->redirectToRoute('company_information', [
                'company' => $company->getId()
            ]);
        }

        return $this->render('company/information.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
            'average' => $companyNoticeRepository->averageStar($company)
        ]);
    }
}
