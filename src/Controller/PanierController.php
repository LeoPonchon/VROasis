<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        $items = ["test","test2","test3"];
        $total = 10;

        return $this->render('panier/index.html.twig', ['total' => $total, 'items' => $items]);
    }
}
