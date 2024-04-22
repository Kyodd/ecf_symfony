<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Prets;
use App\Entity\Salle;
use App\Entity\Reservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserHistoryController extends AbstractController
{
    #[Route('/user/history', name: 'app_user_history')]
    public function index(ManagerRegistry $ManagerRegistry): Response
    {
        $user = $ManagerRegistry->getRepository(User::class)->findAll();
        $livre = $ManagerRegistry->getRepository(Livre::class)->findAll();
        $prets = $ManagerRegistry->getRepository(Prets::class)->findAll();
        $reservation = $ManagerRegistry->getRepository(Reservation::class)->findAll();
        $salle = $ManagerRegistry->getRepository(Salle::class)->findAll();

        return $this->render('user_history/index.html.twig', [
            'controller_name' => 'UserHistoryController',
            'user' => $user,
            'livre' => $livre,
            'prets' => $prets,
            'reservation' => $reservation,
            'salle' => $salle,
        ]);
    }
}
