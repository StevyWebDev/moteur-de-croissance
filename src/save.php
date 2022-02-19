<?php

    /* public function test(CompanyRepository $company, CompanyActivityRepository $activities, UnderActivityRepository $underActivity, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $filterUnderActivities = isset($request->get('search')['underActivities']) ? $request->get('search')['underActivities'] : null;

        if($request->get('search_activity') && $request->get('search_activity') !== "") {

            
            $arrayCompany = $company->findByUnderActivity($filterUnderActivities);
            
            return new JsonResponse([
                'content' => $this->renderView('home/searchActivity.html.twig', [
                    'test' => "test",
                    'companies' => $arrayCompany
                ])
            ]);
        }



        $filter = trim($request->get('param'));
        
        if($request->get('ajax') && $request->get('ajax') !== "") {
            $arrayFilter = explode(" ", $filter);
            //for($i = 0; $i < count($arrayFilter); $i++) {
             //   $test[$i]['name'] = $arrayFilter[$i];
            //} 
            $companies = $company->findCompanyBySearch($arrayFilter);
            return new JsonResponse([
                'content' => $this->renderView('home/search.html.twig', [
                    'test' => $companies,
                ])
            ]);
        }
        
         // Find sur company
         // Find sur Activity
         // Find sur Under Activity
         // On refait un find Compagny avec se que l'on a récupérer précédement
         // On index en premier les resultat recuperer par le premier Find puis le deuxieme puis le troisieme
         // On utilisera la fonction push pour créé un tableau en filtrant pour éviter les doublons
        
        //dump($activity->findCompanyActivityBySearch('assu'));
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'formSearch' => $form->createView()
        ]);
    }

   
    public function search(Request $request, CompanyActivityRepository $activity) {
        

        return $this->render('home/search.html.twig', [
            'test' => $request->get('param')?$activity->findCompanyActivityBySearch($request->get('param')):null
        ]);
    } */
