<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'disabled' => true,
                'label' => 'Votre nom'
                ])
            ->add('lastname',TextType::class,[
                'disabled' => true,
                'label' => 'Votre prénom'
                ])
            ->add('email',EmailType::class,[
                'disabled' => true,
                'label' => 'Votre email'
                ])
            ->add('old_password', PasswordType::class,[
                'label' => 'Mot de passe actuel',
                'mapped' =>false,
                'attr' =>[
                    'placeholder'=>'Veuillez saisir votre mot de passe actuel'
                ]
                ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent etre identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Votre mot de passe', 'attr' => [
                    'placeholder' => 'Merci de saisir un nouveau mot de passe'
                ]],
                'second_options' => ['label' => 'Confirmez votre mot de passe','attr' => [
                    'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                ]],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                    
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Mettre a jour'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
