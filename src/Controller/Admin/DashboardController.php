<?php

namespace App\Controller\Admin;

use App\Entity\Carriers;
use App\Entity\Category;
use App\Entity\Fashion;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Products;
use App\Entity\User;
use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController 
{

    private $users;
    private $produits;

    public function __construct(UserRepository $users, ProductsRepository $produits)
    {
        $this -> users = $users;
        $this -> produits = $produits;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles2\EasyAdminBundle\welcome.html.twig', [
            'allUsers' => $this->users ->allUsers(),
            'produits' => $this -> produits -> allProduits()

        ]);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getUsername())
            ->setAvatarUrl('http://www.nretnil.com/avatar/LawrenceEzekielAmos.png')
            ->setMenuItems([
                        //    MenuItem::linkToRoute('account', 'fa fa-id-card'),
                        // //    MenuItem::linkToRoute('Settings', 'fa fa-user-cog'),
                        MenuItem::section(),
                           MenuItem::linkToLogout('Logout', 'fa fa-sign-out'), ]);
            // ->setGravatarEmail($user->getEmail());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dabchi.COM');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Home', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Fashion', 'fas fa-desktop', Fashion::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Nos Produits', 'fas fa-tag', Products::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carriers::class);
        yield MenuItem::linkToCrud('Headers', 'fas fa-desktop', Header::class);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
