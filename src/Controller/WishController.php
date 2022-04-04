<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create', name: '_create')]
    public function create(
        Request                $request,
        EntityManagerInterface $em
    ): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setIsPublished(true);

            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            $this->addFlash("success", "souhait ajouté");
            return $this->redirectToRoute(
                'wish_detail',
                ["id" => $wish->getId()]
            );
        }

        return $this->renderForm(
            'wish/create.html.twig',
            compact("wishForm")
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
