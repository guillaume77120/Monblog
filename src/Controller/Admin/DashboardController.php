<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ArticlesCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Monblog1');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Articles', 'fa-solid fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Ajout d\'un article', 'fas fa-plus', Articles::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des articles', 'fas fa-eye', Articles::class)
        ]);
        yield MenuItem::subMenu('Utilisateurs', 'fa-solid fa-users')->setSubItems([
            MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-eye', User::class)
        ]);
        yield MenuItem::linkToUrl('Revenir sur le site', 'fa-solid fa-square-caret-left', $this->generateUrl('app_home'));
    }
}
