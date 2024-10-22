<?php

namespace App\Controller\Admin;

use App\Entity\History\History;
use App\Entity\Member\Member;
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

    #[Route('/api', name: 'api')]
    public function api(): Response
    {
        return $this->redirect('/api');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Админ-панель')
            ->setDefaultColorScheme('dark');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Участники', 'fa-solid fa-user', Member::class);
        yield MenuItem::linkToCrud('История СВО / Харовск и СВО', 'fa-solid fa-map', History::class);

        #yield MenuItem::linkToDashboard('Главный экран', 'fa-regular fa-image');

        yield MenuItem::section('Настройки');
        yield MenuItem::linkToRoute('API', 'fa-solid fa-link', 'api');
    }
}
