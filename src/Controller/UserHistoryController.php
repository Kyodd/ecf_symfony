<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Prets;
use App\Entity\Salle;
use App\Entity\Reservation;
use App\Repository\PretsRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/user/history/extension/{id}', name: 'app_user_history_extension', methods: ['GET'])]
public function extension(PretsRepository $pret, $id, ManagerRegistry $doctrine): Response
{
    $pret = $pret->find($id);
    $entityManager = $doctrine->getManager();
    // Vérifie si la réservation n'a pas déjà été étendue
    if (!$pret->getExtension()) {
        // Ajoute 6 jours à la date de fin de la réservation
        
        $dateFin = clone ( $pret->getDateFin());
        $newEndDate = $dateFin->modify("+6 day");
        $pret->setDateFin($newEndDate);
        // $entityManager->persist($pret);
        // $entityManager->flush();
        $pret->setExtension(true); 
       
        // Enregistre les modifications
        $entityManager->persist($pret);
        $entityManager->flush();
    }

    // Redirige l'utilisateur vers la page de détail du livre
    return $this->redirectToRoute('app_user_history');
}
    
}
