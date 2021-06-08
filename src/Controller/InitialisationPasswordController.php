<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InitialisationPasswordController extends AbstractController
{
    /**
     * @Route("/initialisation/password", name="initialisation_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $notification = null;

        $user=$this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $old_pwd=$form->get('old_password')->getData();
            // dd($old_pwd);
            if($passwordEncoder->isPasswordValid($user, $old_pwd)){
                $new_pwd=$form->get('new_password')->getData();
                $password= $passwordEncoder->encodePassword($user, $new_pwd);
                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $notification = "Votre mot de passe a bien été mise à jour";
            } 
            else 
            { 
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }

        }
        return $this->render('account/initialisePassword.html.twig', [
            'form' => $form -> createView(),
            'notification' => $notification
        ]);
    }
}
