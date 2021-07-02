<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carriers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user=$options['user'];

        $builder
        ->add('addresses', EntityType::class,[
            'label' => false,
            'required' => true,
            'class' => Address::class,
            'choices' =>$user->getAddresses(),
            'expanded' => true,
            'multiple' => false
        ]) 
        ->add('carries', EntityType::class,[
            'label' => 'Choisir mon transporteur',
            'required' => true,
            'class' => Carriers::class,
            'expanded' => true,
            'multiple' => false
        ])  
        ->add('submit', SubmitType::class,[
            'label' => 'Valider ma commande',
            'attr' => [
                'class' => 'btn btn-success btn-block'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user'=>array()
        ]);
    }
}
