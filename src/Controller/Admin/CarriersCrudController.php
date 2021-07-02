<?php

namespace App\Controller\Admin;

use App\Entity\Carriers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarriersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carriers::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
