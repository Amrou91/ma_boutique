<?php


namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root', ['childrenAttributes' => ['class' => 'main-nav nav navbar-nav']]);

        $menu->addChild('Nos Produits', ['route' => 'products']);
        $menu->addChild('Contacts', ['route' => 'contact']);
        $menu->addChild('Aidez-moi', ['route' => 'home']);

        // $menu->addChild('Produits', ['route' => 'produits']);
        // ... add more children

        return $menu;
    }
}
