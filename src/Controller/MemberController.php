<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MemberRepository;
use App\Entity\Member;

class MemberController extends AbstractController
{
    private MemberRepository $memberRepository;
    
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }
    
    #[Route('/member', name: 'app_member_index')]
    public function index(): Response
    {
        $members = $this->memberRepository->findAll();
        $Member = $this->getUser(); // Symfony retourne l'objet User actuel
        
        return $this->render('member/index.html.twig', [
            'Members' => $members,
            'currentMemberId' => $Member ? $Member->getId() : null,
        ]);
    }
    
    #[Route('/member/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
