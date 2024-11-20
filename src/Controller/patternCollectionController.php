<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\patternCollection;
use App\Repository\patternCollectionRepository;


class patternCollectionController extends AbstractController
{      
    /**
     * Lists all patternCollections.
     */
    
    #[Route('/pattern/collection/list', name: 'app_pattern_collection_list', methods: ['GET'])]
    public function listCollections(patternCollectionRepository $patternCollectionRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $patternCollections = $patternCollectionRepository->findAll();
        }
        else {
            $member = $this->getUser();
            $patternCollections = $member->getPatternCollection();
        }
        
        return $this->render('pattern_collection/list.html.twig', [
            'patternCollections' => $patternCollections,
        ]);
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
