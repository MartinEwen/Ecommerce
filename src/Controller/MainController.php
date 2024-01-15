<?php

namespace App\Controller;

use App\Repository\GammeRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $products = $productsRepository->findAll();
        shuffle($products);

        return $this->render('main/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin', name: 'app_main_admin')]
    public function admin(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
