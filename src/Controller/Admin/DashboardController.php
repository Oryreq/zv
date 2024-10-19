<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted("ROLE_ADMIN")]
#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Админ-панель')
            ->setDefaultColorScheme('dark');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Участники', 'fa-solid fa-user');
        yield MenuItem::linkToDashboard('История СВО / Харовск и СВО', 'fa-solid fa-map');
        yield MenuItem::linkToDashboard('Главный экран', 'fa-regular fa-image');

        yield MenuItem::section('Настройки');
        yield MenuItem::linkToDashboard('API', 'fa-solid fa-link');
    }
}
