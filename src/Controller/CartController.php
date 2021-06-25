<?php

namespace App\Controller;

use App\Data\Cart;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }

    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        
        return $this->render('cart/index.html.twig',[
            'cart' => $cart ->getFull()
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="add_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

     /**
     * @Route("/cart/delete/{id}", name="delete_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decreaser/{id}", name="decreaser_cart")
     */
    public function decreaser(Cart $cart, $id)
    {
        $cart->decreaser($id);

        return $this->redirectToRoute('cart');
    }
}
