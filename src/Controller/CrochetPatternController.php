<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\CrochetPattern;

class CrochetPatternController extends AbstractController
{
    #[Route('/crochet/pattern', name: 'app_crochet_pattern')]
    public function index(): Response
    {
        return $this->render('crochet_pattern/index.html.twig', [
            'controller_name' => 'CrochetPatternController',
        ]);
    }
    
    /**
     * Show a Crochet Pattern.
     *
     * @param int $id
     *
     * Dans cette partie, j'utilise twig.
     */
    
    #[Route('/crochet/pattern/{id}', name: 'app_crochet_pattern_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showCollection(ManagerRegistry $doctrine, $id): Response
    {
        $crochetPatternRepo = $doctrine->getRepository(CrochetPattern::class);
        $crochetPattern = $crochetPatternRepo->find($id);
        
        return $this->render("crochet_pattern/show.html.twig", [
            'crochetPattern' => $crochetPattern
        ]);
    }
}
