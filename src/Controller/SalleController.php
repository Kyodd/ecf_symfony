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
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(SalleRepository  $salleRepo, EquipementRepository $equiRepo ): Response
    {

        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }else if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_home');
        }else{
            $salles = $salleRepo ->findAll();
            $equip = $equiRepo ->findAll();
            
            return $this->render('salle/index.html.twig', [
                'salles' => $salles,
            ]);
        }
        
       
    }

    #[ROUTE('/salle/{id}', name:'app_salle_reservation', methods: ['GET','POST'])]
    public function reservation($id,ReservationRepository $calendar,Request $request, TranslatorInterface $translator, SalleRepository $salle): Response
    {    
        if ($this->isGranted('ROLE_USER')) {
            $events = $calendar->findAll();
            $rdvs = [];
          
          
            foreach($events as $event){
             
            if($event->getUser()->getId()==$this->getUser()->getId()){
                $colorBg  = 'blue';
                $message1 = $translator->trans('Votre réservation');
                $title  = $message1;
            }else{
                $colorBg  = 'red';
                $message2 = $translator->trans('Indisponible');
                $title  = $message2;
            }
                if($event->getSalle()->getId() ==$id ){
                    $rdvs[] = [
                        'id' => $event->getId(),
                        'idSalle'=>$id,
                        'title'=>$title,
                        'start' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                        'end' => $event->getDateFin()->format('Y-m-d H:i:s'),                   
                        'backgroundColor' =>  $colorBg,
                        'borderColor' => $colorBg,
                        'textColor' => $event->getTextColor(),
                      
                    ];
                }
            } 
    
            $data = json_encode($rdvs);

            $message3 = $translator->trans('Voulez-vous réserver ce créneau ?');
            $confirmMsg  = $message3;

            $message4 = $translator->trans('Merci de choisir le nombre d\'heure de votre réservation en fonction des disponibilités ( maximum possible dans l\'absolu : 4h )?');
            $chooseHourSlot  = $message4;

            $message5 = $translator->trans('Veuillez choisir un créneau de moins de 4h');
            $errorHours  = $message5;
          
           
          
            return $this->render('salle/reservation.html.twig', 
            [
                'data' => $data,
                'id'=> $id,
                'confirmMsg'=>$confirmMsg,
                'chooseHourSlot'=> $chooseHourSlot ,
                'errorHours'=>$errorHours


            ]
            );
        }else {
            return $this->redirectToRoute('app_home');
        }
       
    }

    #[ROUTE('/save-event/{id}', name:'save_event',methods: ['POST'])]
    public function saveEvent($id,ReservationRepository $calendar,Request $request, EntityManagerInterface $entityManager, Security $security, UserRepository $user, SalleRepository $salle, TranslatorInterface $translator): Response
    {    

        $reservations = $calendar->findAll();
        $eventData = $request->request->get('event-data');
        $event = json_decode($eventData, true);
        $dateAdd= new \DateTime($event['end']);
            $dateAdd=$dateAdd->format('d/m/Y');
            $salleId = $id;
             $salle = $salle->find($salleId); 
             $error= false; 
        foreach($reservations as $reservation){

            $dateCurr=$reservation->getDateDebut()->format('d/m/Y');
        

            if($reservation->getSalle()->getId() ==$id ){
   if(new \DateTime($event['end'])>$reservation->getDateDebut() && new \DateTime($event['start'])<$reservation->getDateDebut() && $dateAdd==$dateCurr){
 
        $error= true;

        $date=new \DateTime($event['start']);
        $date=$date->format('H');
        $dateReservation=$reservation->getDateDebut()->format('H');
        $dateInt=intval($date);
        $dateReservationInt=intval($dateReservation);
        $gapHeure=$dateReservationInt - $dateInt;
        $rdvs[] = [
            'gapHeure' => $gapHeure,
         
        ];
   
   }
   
}

        }

        
        if($error){
            
        $gpH=$rdvs[0]['gapHeure'];
        foreach($rdvs as  $index =>$rdv){
           
            $num=count($rdvs);
          
            if($num>$index+1){
             
                if($rdv['gapHeure']>$rdvs[$index+1]['gapHeure'] ){
                    $gpH==$rdvs[$index+1]['gapHeure'];
                }
            }
           
       
        }
        $message = $translator->trans('Veuillez réserver un créneau en fonction des disponibilités. Heures disponibles pour ce créneau : ');
        $error = $message;
            return $this->render('salle/error.html.twig', 
            [
                'id' => $id,
                'gapHeure'=>  $gpH,
                'error'=>$error
            ]
            );
            
         
        }else{
            $user = $this->getUser();
            $reservation = new Reservation();
            $reservation->setUser($user);
            $reservation->setSalle($salle );
            $reservation->setDateDebut(new \DateTime($event['start']));
            $reservation->setDateFin(new \DateTime($event['end']));
           
            $reservation->setBackgroundColor('red');
            $reservation->setBorderColor('red');
            $reservation->setTextColor('white');
               $entityManager->persist($reservation);
             $entityManager->flush();
           
            return $this->redirectToRoute('app_salle_reservation',['id' => $salle->getId()]);
        }
       
       
       
        
    }
    #[ROUTE('/salle/error/{id}', name:'app_salle_error_reservation', methods: ['GET'])]
public function error($id,ReservationRepository $calendar,Request $request, SalleRepository $salle): Response
{    

  
    return $this->render('salle/error.html.twig', [
        'id' => $id,
      
    ]);
    // return $this->redirectToRoute('app_salle_reservation',['id' =>$id ]);
}
}
