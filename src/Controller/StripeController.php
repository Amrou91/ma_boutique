<?php

namespace App\Controller;

use App\Data\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Order;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {

        $product_for_stripe=[];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';


        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }


        foreach($order->getOrderDetails()->getValues() as $product){
            $product_object = $entityManager->getRepository(Products::class)->findOneByName($product->getProduct());
            $product_for_stripe[]=[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/images/".$product_object->getFeaturedImage()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $product_for_stripe[] = [ 
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice() * 100,
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

        // dd($product_for_stripe);

        Stripe::setApiKey('sk_test_51J96frLi3uDNMuzADzQUq2Ix7VojK8xoinKX63bsBWOwpvireZRxd9zjeQ15qiCe3xyYknAKR2DIOybItC0Yeukh003oAXaz7q');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;


    } 
}


