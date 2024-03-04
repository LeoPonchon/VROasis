<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\AddProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function show(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $rating = 0;
        $totalRating = 0;
        $numberOfRatings = 0;
        $ratings = [];
        foreach ($products as $product) {
            $ratings[] = $productRepository->findColumn("rating", $product->getId())[0]['rating'];
        }

        return $this->render('product/index.html.twig', ['rating' => $rating, 'ratings' => $ratings, 'products' => $products]);
    }
    

    #[Route('/product/{id}/add-to-cart', name: 'app_product_add_to_panier')]
    public function addToPanier(Product $product, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cart = $user->getPanier();
    
        $cart[] = $product;
    
        $user->setPanier($cart);
        
        $entityManager->persist($user);
        $entityManager->flush();
    
        // Redirect back to the product listing page
        return $this->redirectToRoute('app_product');
    }

    #[Route('/product/{id}/rate/{stars}', name: 'app_product_rate')]
    public function rateProduct(Product $product, int $stars, EntityManagerInterface $entityManager): Response
    {
        $ratings = $product->getRating();
        $ratings[] = $stars;
        $product->setRating($ratings);
    
        $entityManager->flush();
    
        // Rediriger vers la page de liste des produits
        return $this->redirectToRoute('app_product');
    }
    
}