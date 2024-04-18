<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Reservation;
use App\Repository\UserRepository;
use App\Repository\SalleRepository;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;


use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(SalleRepository  $salleRepo, EquipementRepository $equiRepo ): Response
    {
        $salles = $salleRepo ->findAll();
        $equip = $equiRepo ->findAll();

    

        return $this->render('salle/index.html.twig', [
            'salles' => $salles,
        ]);
    }

    #[ROUTE('/salle/{id}', name:'app_salle_reservation')]
    public function reservation(ReservationRepository $calendar): Response
    {    
     
        $events = $calendar->findAll();

        $rdvs = [];
        $bg = 'inverse-background';
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'title'=>'Indisponible',
                'start' => $event->getDateFin()->format('Y-m-d H:i:s'),
                'end' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                'backgroundColor' => 'red',
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
              
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('salle/reservation.html.twig', 
            compact('data'));
    }

    #[ROUTE('/save-event', name:'save_event',methods: ['POST'])]
    public function saveEvent(ReservationRepository $calendar,Request $request, EntityManagerInterface $entityManager, Security $security, UserRepository $user, SalleRepository $salle): Response
    {    

        $eventData = $request->request->get('event-data');
        $event = json_decode($eventData, true);
       dump( $event);
        $roomId = 18;
        $room = $salle->find($roomId);
        $userId = 13;
        $user = $user->find($userId);
        
    

        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setSalle($room);
        $reservation->setDateDebut(new \DateTime($event['start']));
        $reservation->setDateFin(new \DateTime($event['end']));
          $reservation->setBackgroundColor('red');
            $reservation->setBorderColor('red');
          $reservation->setTextColor('white');
        // Définissez d'autres propriétés de l'entité Reservation si nécessaire
    
        $entityManager->persist($reservation);
        $entityManager->flush();
    
        // Vous pouvez rediriger ou renvoyer une réponse appropriée
        return $this->redirectToRoute('app_salle_reservation',['id' => $reservation->getId()]);
   
    }
}
