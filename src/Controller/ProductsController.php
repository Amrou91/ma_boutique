<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }
    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(): Response
    {
        $produits = $this -> entityManager ->getRepository(Products::class)->findAll();
        return $this->render('products/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/nos-produits/{slug}", name="show_products")
     */
    public function show($slug): Response
    {
        $produit = $this -> entityManager ->getRepository(Products::class)->findOneBySlug($slug);
        return $this->render('products/show.html.twig', [
            'produit' => $produit,  
        ]);
    }
}
