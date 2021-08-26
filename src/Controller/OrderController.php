<?php

namespace App\Controller;

use App\Data\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }
    
    /**
     * @Route("/command", name="order")
     */
    public function index(Cart $cart): Response
    {

        if( !$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('ajouter_address');
        }
        
        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form -> createView(),
            'cart' => $cart ->getFull()
        ]);
    }

    /**
     * @Route("/command/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request)
    {
        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $date=new \DateTime();
            $carries=$form->get('carries')->getData();
            $delivry=$form->get('addresses')->getData();
            $delivry_content=$delivry->getFirstname().' '.$delivry->getLastname();
            if($delivry->getCompany()){
                 $delivry_content .= '</br>'.$delivry->getCompany();
            }
            $delivry_content .= '</br>'.$delivry->getPhone();
            $delivry_content .= '</br>'.$delivry->getAddress();
            $delivry_content .= '</br>'.$delivry->getPostal().' '.$delivry->getCity();
            $delivry_content .= '</br>'.$delivry->getCountry();
            
            $order=new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order ->setUser($this->getUser());
            $order ->setCreatedAt($date);
            $order ->setCarrierName($carries->getName());
            $order ->setCarrierPrice($carries->getPrice());
            $order ->setDelivry($delivry_content);
            $order ->setState(0);
            $this -> entityManager->persist($order);
            
           

            foreach($cart->getFull() as $product){
                $orderDetails= new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice()*$product['quantity']);
                $this -> entityManager->persist($orderDetails);

            }

            $this -> entityManager->flush();


            return $this->render('order/add.html.twig', [
                'cart' => $cart ->getFull(),
                'carrier' => $carries,
                'delivry' => $delivry_content,
                'reference' => $order->getReference()
            ]);
        } 

        return $this->redirectToRoute('cart'); 
    }
}
