<?php

namespace App\Controller\Admin;

use App\Entity\Mode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ModeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mode::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            AssociationField::new('modes'),
        ];
    }
}
