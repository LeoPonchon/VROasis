<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;


class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(UserRepository $userRepository): Response
    {
        $nomArticle = [];
        $prixArticle = [];
        $total = 0;

        $panier = $userRepository->findColumn("panier", $this->getUser()->getId())[0]['panier'];

        foreach ($panier as $product) {
            $nomArticle[] = $product->getName();
            $prixArticle[] = $product->getPrice();
            $total += $product->getPrice();
        }

        return $this->render('panier/index.html.twig', ['nomArticle' => $nomArticle, 'prixArticle' => $prixArticle, 'total' => $total, 'panier' => $panier]);
    }

    #[Route('/product/{id}/remove_from_panier', name: 'app_panier_remove_from_panier')]
    public function removeFromPanier(Product $product, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $panier = $user->getPanier();
        $key = array_search($product, $panier);
        unset($panier[$key]);
    
        $user->setPanier($panier);
        
        $entityManager->persist($user);
        $entityManager->flush();
    
        // Redirect back to the product listing page
        return $this->redirectToRoute('app_panier');
    }
}
