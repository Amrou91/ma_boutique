<?php

namespace App\Controller;

use App\Data\Cart;
use App\Classe\Mail;
use App\Entity\Address;
use App\Entity\Order;
use App\Services\SendMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, SendMailer $mail, $stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0) {
            // Vider la session "cart"
            $cart->remove();

            // Modifier le statut isPaid de notre commande en mettant 1
            $order->setState(1);
            $this->entityManager->flush();

            // Envoyer un email à notre client pour lui confirmer sa commande
            // $mail = new Mail();
            // $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande.<br><br/>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam expedita fugiat ipsa magnam mollitia optio voluptas! Alias, aliquid dicta ducimus exercitationem facilis, incidunt magni, minus natus nihil odio quos sunt?";
            // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande La Boutique Française est bien validée.', $content);

            $context = [
                'firstName' => $order->getUser()->getFirstname(),
                'lastName' => $order->getUser()->getLastname(),
                'mail' => $order->getUser()->getEmail(),
            ]; 

            $mail->send(
                $order->getUser()->getEmail(), 
                'omar@domaine.fr',
                'Merci pour votre commande',
                'payement',
                $context
            ); }

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
