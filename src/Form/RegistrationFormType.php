<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prenom',
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage' => 'Votre Prenom Minimum {{ limit }} caractères',
                    'max' => 20,
                    'maxMessage' => 'Votre Prenom Maximum {{ limit }} caractères',
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom'
                ]])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage' => 'Votre Nom Minimum {{ limit }} caractères',
                    'max' => 20,
                    'maxMessage' => 'Votre Prenom Maximum {{ limit }} caractères',
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 55
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre email'
                ]])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe de la confirmation doivent etre identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Votre mot de passe', 'attr' => [
                    'placeholder' => 'Merci de saisir un mot de passe'
                ]],
                'second_options' => ['label' => 'Confirmez votre mot de passe','attr' => [
                    'placeholder' => 'Confirmez un mot de passe'
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
                        'max' => 15,
                    ]),
                ],
                
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Vous Devez Accepter Nos Conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions',
                    ]),
                ],
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
