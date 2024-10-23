<?php

namespace App\Controller\Login;

use App\Entity\History\ContentType;
use App\Entity\MainScreen\MainScreen;
use App\Entity\Member\MemberType;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Service\Attribute\Required;


#[Route(path: '/admin')]
class LoginController extends AbstractController
{
    #[Required]
    public EntityManagerInterface $entityManager;

    private function databaseFieldsInit(): self
    {
        $user = new User();
        $user->setUsername('admin')
            ->setPassword('admin')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword('$2y$13$6iF/X1U1ePbKfOeHYbp3V.yxNa5lJUcplsBGnmiISBaKV5GffPMQi');
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $memberType = new MemberType();
        $memberType->setName('Герои Российской Федерации')
            ->setApiResource('heroes');
        $this->entityManager->persist($memberType);
        $this->entityManager->flush();

        $memberType2 = new MemberType();
        $memberType2->setName('Харовчане-участники СВО')
            ->setApiResource('harovchane');
        $this->entityManager->persist($memberType2);
        $this->entityManager->flush();

        $contentType = new ContentType();
        $contentType->setValue('История СВО')
            ->setApiResource('heroes');
        $this->entityManager->persist($contentType);
        $this->entityManager->flush();
        $contentType2 = new ContentType();
        $contentType2->setValue('Харовск и СВО')
            ->setApiResource('harovsk');
        $this->entityManager->persist($contentType2);
        $this->entityManager->flush();

        $mainScreen = new MainScreen();
        $mainScreen->setValue1('СПЕЦИАЛЬНАЯ ВОЕННАЯ ОПЕРАЦИЯ')
            ->setValue2('ГЕРОЙ РОССИЙСКОЙ ФЕДЕРАЦИИ')
            ->setValue3('ХАРОВЧАНЕ-УЧАСТНИКИ СВО');
        $this->entityManager->persist($mainScreen);
        $this->entityManager->flush();
        return $this;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $optionalUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'admin']);
        if (!$optionalUser) {
            $this->databaseFieldsInit();
        }

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,

            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('admin'),

            'username_label' => 'Логин',
            'password_label' => 'Пароль',
            'sign_in_label' => 'Вход',

            'remember_me_enabled' => true,
            'remember_me_checked' => true,
            'remember_me_label' => 'Запомнить',
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
