<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BanController extends AbstractController
{
    #[Route('/ban', name: 'app_ban')]
    
    public function index(UserRepository $userBanList): Response
    {
        $banList = $userBanList->bannedUsers();

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('ban/index.html.twig', [
            'controller_name' => 'BanController',
            'banList' => $banList,
        ]);
    }

    #[Route('/unBan/{id}', name: 'app_unBan_user', methods: ['GET'])]

    public function unBanUser(User $user, EntityManagerInterface $entityManagerInterface): Response
    {
        $user->setBanned(false);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_ban');
    }

    #[Route('/ban/{id}', name: 'app_ban_user', methods: ['GET'])]

    public function banUser(User $user, EntityManagerInterface $entityManagerInterface): Response
    {
        $user->setBanned(true);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_user_admin_index');
    }

}


