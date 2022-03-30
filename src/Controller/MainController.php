<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/aboutus', name: 'main_about_us')]
    public function aboutus(): Response
    {
        $data = file_get_contents("../data/team.json");
        $team = json_decode($data, true);
        return $this->render(
            'main/aboutus.html.twig',
            compact("team")
        );
    }
}
