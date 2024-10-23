<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Crud\MemberCrudController;
use App\Entity\History\History;
use App\Entity\MainScreen\MainScreen;
use App\Entity\Member\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;


#[IsGranted("ROLE_ADMIN")]
#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{
    #[Required]
    public EntityManagerInterface $entityManager;

    #[Required]
    public AdminUrlGenerator $adminUrlGenerator;

    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
                    ->setController(MemberCrudController::class)
                    ->setAction(Action::INDEX)
                    ->generateUrl();
        return $this->redirect($url);
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

        yield MenuItem::linkToCrud('Главный экран', 'fa-regular fa-image', MainScreen::class)
                            ->setAction(Action::EDIT)
                            ->setEntityId($this->entityManager->getRepository(MainScreen::class)->findAll()[0]->getId());

        yield MenuItem::section('Настройки');
        yield MenuItem::linkToRoute('API', 'fa-solid fa-link', 'api');
    }
}
