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
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProductsCrudController extends AbstractCrudController 
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $detail=Action::new('detailUser','Details') 
                    ->linkToCrudAction(Crud::PAGE_DETAIL);
        return $actions
                    ->add(Crud::PAGE_INDEX, $detail);  
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnDetail(), 
            TextField::new('name','Nom des Produits'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            BooleanField::new('isBest', 'Meilleure'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextField::new('subtitle')->hideOnIndex(),
            ImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyOnDetail(), 
                // ->hideOnDetail(),
            ImageField::new('featured_image')
                ->setBasePath('images/products')
                ->setUploadDir('public/images/products')
                ->setLabel('Image')
                ->setRequired(false),
            DateTimeField::new('created_at', 'Créer Le ...')->onlyOnIndex(),
            DateTimeField::new('update_at', 'Mise à jour')->onlyOnDetail(), 
            TextEditorField::new('description'),
            AssociationField::new('category', 'Catégories'),
            AssociationField::new('fashion', 'Modes'),

        ];
    }
    
}
