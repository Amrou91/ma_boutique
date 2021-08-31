<?php

namespace App\Controller\Admin;

use App\Entity\Carriers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarriersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carriers::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR')  
        ];
    }
    
}
