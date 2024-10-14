<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\patternCollection;


class patternCollectionController extends AbstractController
{
    #[Route('/pattern/collection', name: 'app_pattern_collection')]
    public function index(): Response
    {
        return $this->render('pattern_collection/index.html.twig', [
            'controller_name' => 'patternCollectionController',
        ]);
    }
    
    /**
     * Lists all patternCollections.
     */
    
    #[Route('/pattern/collection/list', name: 'app_pattern_collection_list', methods: ['GET'])]
    public function listCollections(ManagerRegistry $doctrine): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des collections</title>
    </head>
    <body>
        <h1>Liste des collections de patrons:</h1>
        <ul>';
        
        $entityManager = $doctrine->getManager();
        $patternCollections = $entityManager->getRepository(patternCollection::class)->findAll();
        
        foreach ($patternCollections as $patternCollection) {
            $url = $this->generateUrl(
                'app_pattern_collection_show',
                ['id' => $patternCollection->getId()]);
            $htmlpage .= '<li><a href='.$url.'>'. $patternCollection->getName() . '</a></li>';
        }
        
        $htmlpage .= '</ul>
    </body>
</html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
            );
    }
    

    /**
     * Show a Pattern Collection.
     *
     * @param int $id
     *
     * AVEC TWIG
     */
    
    #[Route('/pattern/collection/{id}', name: 'app_pattern_collection_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showCollection(ManagerRegistry $doctrine, $id): Response
    {
        $patternCollectionRepo = $doctrine->getRepository(patternCollection::class);
        $patternCollection = $patternCollectionRepo->find($id);
        
        return $this->render('pattern_collection/show.html.twig', [
            'patternCollection' => $patternCollection
        ]);
    }   
    
}
