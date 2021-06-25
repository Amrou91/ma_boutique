<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Products;
use App\Form\SearchType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

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
    public function index(ProductsRepository $produit, Request $request): Response
    {
        $data= new SearchData();
        $data->page=$request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $produits=$produit->findAll();
        $form -> handleRequest($request);
        // dd($data);
        $produits=$produit->Search($data);
        
        return $this->render('products/index.html.twig', [
            'produits' => $produits,
            'form' => $form ->createView()
        ]);
    }

    /**
     * @Route("/nos-produits/{slug}", name="show_products")
     */
    public function show($slug): Response
    {
        $produit = $this -> entityManager ->getRepository(Products::class)->findOneBySlug($slug);
        if(!$produit){
            $this->redirectToRoute('products');
        }
        return $this->render('products/show.html.twig', [
            'produit' => $produit,  
        ]);
    }
}
