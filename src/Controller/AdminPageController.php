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
    #[Route('/admin', name: 'app_admin')]
    public function show(ProductRepository $productRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
        }

        $products = $productRepository->findAll();
        $users = $userRepository->findAll();
        return $this->render('admin_page/index.html.twig', ['users' => $users, 'form' => $form, 'products' => $products]);
    }

    #[Route('/admin/user/delete/{id}', name: 'delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/product/delete/{id}', name: 'delete_product')]
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }
}