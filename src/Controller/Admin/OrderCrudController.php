<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail=Action::new('detail','Details', 'fa fa-tag') 
                    ->linkToCrudAction(Crud::PAGE_DETAIL)
                    ->addCssClass('btn btn-info');
        return $actions
                    ->add(Crud::PAGE_INDEX, $detail); 
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('user.fullname', 'Utilisateur'), 
            DateTimeField::new('created_at', 'Passée le')->onlyOnIndex(),
            MoneyField::new('total')->setCurrency('EUR'),
            BooleanField::new('isPaid', 'Payée')
        
        ];
    }
    
}
