<?php

namespace App\Controller;

use App\Entity\CrochetPattern;
use App\Form\CrochetPatternType;
use App\Repository\CrochetPatternRepository;
use App\Entity\patternCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crochet/pattern')]
final class CrochetPatternController extends AbstractController
{
    #[Route('/list', name: 'app_crochet_pattern_index', methods: ['GET'])]
    public function index(CrochetPatternRepository $crochetPatternRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $crochetPatterns = $crochetPatternRepository->findAll();
        } else {
            $member = $this->getUser();
            $crochetPatterns = $crochetPatternRepository->findMemberCrochetPatterns($member);
        }
        
        return $this->render('crochet_pattern/index.html.twig', [
            'crochet_patterns' => $crochetPatterns,
        ]);
    }
    
    #[Route('/{id}', name: 'app_crochet_pattern_show', methods: ['GET'])]
    public function show(CrochetPattern $crochetPattern): Response
    {
        return $this->render('crochet_pattern/show.html.twig', [
            'crochet_pattern' => $crochetPattern,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_crochet_pattern_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CrochetPattern $crochetPattern, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CrochetPatternType::class, $crochetPattern);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('app_crochet_pattern_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('crochet_pattern/edit.html.twig', [
            'crochet_pattern' => $crochetPattern,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_crochet_pattern_delete', methods: ['POST'])]
    public function delete(Request $request, CrochetPattern $crochetPattern, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$crochetPattern->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($crochetPattern);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_crochet_pattern_index', ['id' => $patternCollection->getId()], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/new/{id}', name: 'app_crochet_pattern_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, patternCollection $patternCollection): Response
    {
        $crochetPattern = new CrochetPattern();
        $crochetPattern->setPatternCollection($patternCollection);
        $form = $this->createForm(CrochetPatternType::class, $crochetPattern);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($crochetPattern);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_crochet_pattern_index', ['id' => $patternCollection->getId()], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('crochet_pattern/new.html.twig', [
            'crochet_pattern' => $crochetPattern,
            'form' => $form,
        ]);
    }
}
