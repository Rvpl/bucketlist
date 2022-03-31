<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function list(
        WishRepository $wr
    ): Response
    {
        // $wishes = $wr->findAll();
        $wishes = $wr->findBy(
            ["isPublished" => true], // WHERE
            ["dateCreated" => "DESC"]  // ORDER BY, GROUP BY, ...
        );
        return $this->render(
            'wish/list.html.twig',
            compact("wishes")
        );
    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail(
        int            $id,
        WishRepository $wr
    ): Response
    {
        $wish = $wr->find($id);
        if (!$wish) {
            throw $this->createNotFoundException('Aucun souhait n\'a été trouvé');
        }
        return $this->render(
            'wish/detail.html.twig',
            compact('wish'));
    }
}
