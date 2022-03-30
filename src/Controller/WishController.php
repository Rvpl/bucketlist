<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function list(): Response
    {
        $wishes = [
            'Réussir le titre',
            'Avoir un CDI a 32K'
        ];
        return $this->render(
            'wish/list.html.twig',
            compact("wishes")
        );
    }

    #[Route('/detail', name: '_detail')]
    public function detail(): Response
    {
        return $this->render('wish/detail.html.twig');
    }
}
