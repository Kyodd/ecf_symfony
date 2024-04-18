<?php

namespace App\Controller;

use DateTime;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route("/api", name:"api" )]
    public function index()
    {
        dd('api');
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

     #[Route("/api/{id}/edit", name:"api_event_edit", methods: ['PUT'])]
    public function edit(?Reservation $calendar, Request $request,ManagerRegistry $doctrine)
    {
   
        dd('api1');
        // On récupère les données
        $donnees = json_decode($request->getContent());
 
        if(
         
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->end) && !empty($donnees->end) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) 
           
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Reservation;

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
    
            $calendar->setDateDebut(new DateTime($donnees->start));
          
                $calendar->setDateFin(new DateTime($donnees->end));
            
         
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            $em = $doctrine->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return $this->render('api/index.html.twig', [
                'controller_name' => 'ApiController',
            ]);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


        
    }
}

