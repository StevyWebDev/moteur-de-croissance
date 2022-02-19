<?php

namespace App\Controller;

use App\Entity\CompanyActivity;
use App\Entity\CompanySearch;
use App\Form\CompanySearchType;
use App\Form\SearchType;
use App\Repository\CompanyActivityRepository;
use App\Repository\CompanyRepository;
use App\Repository\UnderActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, CompanyRepository $companyRepository, CompanyActivityRepository $activityRepository) {
        $companySearch = new CompanySearch;

        $form = $this->createForm(CompanySearchType::class, $companySearch);
        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $nameActivity = $activityRepository->findOneById($form->get('nameActivity')->getData());
            $address = $form->get('address')->getData();
            $distance = $form->get('distance')->getData();
            $lat = $form->get('lat')->getData();
            $lng = $form->get('lng')->getData();

            return $this->redirectToRoute('search', [
                "nameActivity" => $nameActivity->getId(),
                "address" => $address,
                "distance" => $distance,
                "lat" => $lat,
                "lng" => $lng,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/search", name="search")
     */
    public function searchCompany(Request $request, CompanyRepository $companyRepository) {
        
        $companySearch = new CompanySearch;

        $form = $this->createForm(CompanySearchType::class, $companySearch);
        $form->handleRequest($request);

        $companies = $companyRepository->search($companySearch);

        return $this->render('home/search.html.twig', [
            'companies' => $companies,
            'form' => $form->createView()
        ]);
    }
    

    

    /**
     * @Route("/nous/politique-de-confidentialite", name="privacyPolicy")
     */
    public function privacyPolicy() {
        return $this->render('home/privacyPolicy.html.twig');
    }

    /**
     * @Route("/ebla-moteur-de-croissance/comment-ca-marche", name="howItWorks")
     */
    public function howItWorks() {
        return $this->render('home/howItWorks.html.twig');
    }
}
