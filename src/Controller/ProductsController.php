<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Service\PictureService;
use App\Repository\GammeRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products', name: 'app_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ProductsRepository $productsRepository, Request $request, GammeRepository $gammeRepository): Response
    {
        
        // $gammes = $gammeRepository->findAll();
        // $page = $request->query->getInt('page', 1);
        // $products = $productsRepository->findProductsPaginated($page, 8);
        $products = $productsRepository->findAll();
        shuffle($products);
        return $this->render('products/index.html.twig', [
            'products' => $products,
            'gammes' => $gammeRepository->findAll(),
        ]);
    }

    #[Route('/adminProducts', name: 'admin', methods: ['GET'])]
    public function productsAdmin(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/adminIndex.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, PictureService $pictureService): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('pictures')->getData();
    
            foreach ($images as $image) {
                $folder = 'pictures';
                $fichier = $pictureService->add($image, $folder);
    
                // Create and persist a new Pictures entity for each uploaded image
                $img = new Pictures();
                $img->setNamePicture($fichier);
                $entityManager->persist($img);
    
                // Add the Pictures entity to the product
                $product->addPicture($img);
            }
    
            // Slugify the product name and set it as the product's slug
            $slug = $slugger->slug($product->getNameProducts())->lower();
            $product->setSlug($slug);
    
            // Persist and flush the product entity
            $entityManager->persist($product);
            $entityManager->flush();
    
            // Redirect to the index page after successful form submission
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // Render the form if it is not submitted or invalid
        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_products_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_admin', [], Response::HTTP_SEE_OTHER);
    }
}
