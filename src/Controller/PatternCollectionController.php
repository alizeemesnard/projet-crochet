<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\PatternCollection;


class PatternCollectionController extends AbstractController
{
    #[Route('/pattern/collection', name: 'app_pattern_collection')]
    public function index(): Response
    {
        return $this->render('pattern_collection/index.html.twig', [
            'controller_name' => 'PatternCollectionController',
        ]);
    }
    
    /**
     * Lists all PatternCollections.
     */
    
    #[Route('/pattern/collection/list', name: 'app_pattern_collection_list', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des collections de patrons:</title>
    </head>
    <body>
        <h1>Liste des collections de patrons:</h1>
        <ul>';
        
        $entityManager = $doctrine->getManager();
        $patternCollections = $entityManager->getRepository(PatternCollection::class)->findAll();
        
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
     * Ancienne méthode sans twig:

    #[Route('/pattern/collection/{id}', name: 'app_pattern_collection_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $patternCollectionRepo = $doctrine->getRepository(PatternCollection::class);
        $patternCollection = $patternCollectionRepo->find($id);
        
        if (!$patternCollection) {
            throw $this->createNotFoundException('The pattern collection does not exist');
        }
        
        // Prepare HTML response
        $res = '<!DOCTYPE html>
            <head>
                <meta charset="UTF-8">
                <title>' . $patternCollection->getName() . '</title>
            </head>
            <h1>' . $patternCollection->getName() . '</h1>
            <p><strong>Designer:</strong> ' . $patternCollection->getDesigner() . '</p>
            <p><strong>Date de création:</strong> ' . $patternCollection->getDateCreated()->format('Y-m-d') . '</p>
            <p><strong>Nombre de patrons:</strong> ' . $patternCollection->getTotalPatterns() . '</p>
            <p><strong>Patrons:</strong></p>
            <ul>';
        
        foreach ($patternCollection->getPatterns() as $pattern) {
            $res .= '<li>' . $pattern->getName() . ' (Hook Size: ' . $pattern->getHookSize() . ')</li>';
        }
        
        $res .= '</ul>
            <p><a href="' . $this->generateUrl('app_pattern_collection_list') . '">Back</a></p>';
        
        return new Response('<html><body>' . $res . '</body></html>');
    }

    
    
     */
    
    
    
    
    
    
    
    
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
