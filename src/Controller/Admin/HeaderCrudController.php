<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du header'),
            TextEditorField::new('content', 'Contenu de notre header'),
            TextField::new('btnTitle', 'Titre de notre header'),
            TextField::new('btnURL', 'URL de destination de notre bouton'), 
            ImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyOnDetail(), 
            ImageField::new('image')
                ->setBasePath('images/products')
                ->setUploadDir('public/images/products')
                ->setLabel('image')
                ->setRequired(false), 
        ];
    }
    
}
