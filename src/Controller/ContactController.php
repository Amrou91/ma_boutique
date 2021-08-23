<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\SendMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, SendMailer $mail): Response
    {
        $form = $this ->createForm(ContactType::class);
        $contact=$form -> handleRequest($request);
        if ($form->isSubmitted() && $form -> isValid())
        {
            $context = [
                'firstName' => $contact->get('firstName')->getData(),
                'lastName' => $contact->get('lastName')->getData(),
                'mail' => $contact->get('email')->getData(),
                'message' => $contact->get('message')->getData(),
            ];

            $mail->send(
                $contact->get('email')->getData(),
                'omar@domaine.fr',
                'Contact depuis le site PetitesAnnonces',
                'contact',
                $context
            );
            $this->addFlash('message','Votre message a bien ete envoyé');

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form ->createView()
        ]);
    }
}
