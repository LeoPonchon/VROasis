<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\AddProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function show(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [ 'products' => $products]);
    }

    #[Route('/product/{id}/add-to-cart', name: 'app_product_add_to_panier')]
    public function addToPanier(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cart = $user->getPanier();
    
        $cart[] = $product->getId();
    
        $user->setPanier($cart);
        
        $entityManager->persist($user);
        $entityManager->flush();
    
        // Redirect back to the product listing page
        return $this->redirectToRoute('app_product');
    }
}