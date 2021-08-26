<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(), 
            TextField::new('name','Nom des Produits'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            BooleanField::new('isBest'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('subtitle')->hideOnIndex(),
            ImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyOnDetail(), 
            ImageField::new('featured_image')
                ->setBasePath('images/products')
                ->setUploadDir('public/images/products')
                ->setLabel('image')
                ->setRequired(false),
            DateTimeField::new('created_at')->onlyOnIndex(),
            DateTimeField::new('update_at')->onlyOnIndex(), 
            TextEditorField::new('description'),
            AssociationField::new('category'),
            AssociationField::new('fashion'),

        ];
    }
    
}
