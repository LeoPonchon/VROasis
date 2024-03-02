<?php

// src/Controller/ProductController.php
namespace App\Controller;

// ...
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
    #[Route('/product', name: 'product_show')]
    public function show(ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $products = $productRepository->findAll();

        $product = new Product();
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            echo "<meta http-equiv='refresh' content='0'>";
        }
        return $this->render('product/index.html.twig', ['form' => $form, 'products' => $products]);
    }
}