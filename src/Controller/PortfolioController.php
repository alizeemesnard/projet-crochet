<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Entity\CrochetPattern;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;


#[Route('/portfolio')]
final class PortfolioController extends AbstractController
{
    #[Route(name: 'app_portfolio_index', methods: ['GET'])]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portfolio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_show', methods: ['GET'])]
    public function show(Portfolio $portfolio): Response
    {
        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_delete', methods: ['POST'])]
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * Show a Crochet Pattern in the portfolio.
     *
     * @param int $id
     *
     * Dans cette partie, j'utilise twig.
     */
    
    #[Route('/{portfolio_id}/crochet/pattern/{pattern_id}', methods: ['GET'], name: 'app_portfolio_crochet_pattern_show')]
    public function CrochetPatternShow(
        #[MapEntity(id: 'portfolio_id')]
        Portfolio $portfolio,
        #[MapEntity(id: 'pattern_id')]
        CrochetPattern $CrochetPattern): Response
        
        {
            if(! $portfolio->getPatterns()->contains($CrochetPattern)) {
                throw $this->createNotFoundException("ERROR 404: Je n'ai pas pu trouver de patron dans ce portfolio !");
            }
            
            //if(! $portfolio->isPublished()) {
            //    throw $this->createAccessDeniedException("ERROR 403: Vous ne pouvez pas accéder à la ressource demandée !");
            //} 
            
            return $this->render('portfolio/CrochetPatternShow.html.twig', [
                'CrochetPattern' => $CrochetPattern,
                'Portfolio' => $portfolio
            ]);
    }
}
