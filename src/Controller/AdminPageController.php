<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Form\AddProductType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPageController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_page')]
    public function show(ProductRepository $productRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
        }

        $users = ["toto", "titi", "tutu"];
        
        $products = $productRepository->findAll();
        $users = $userRepository->findAll();
        return $this->render('admin_page/index.html.twig', ['users' => $users, 'form' => $form, 'products' => $products]);
    }
}