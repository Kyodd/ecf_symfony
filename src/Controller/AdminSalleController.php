<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\UserRepository;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/salle')]
class AdminSalleController extends AbstractController
{
    #[Route('/', name: 'app_admin_salle_index', methods: ['GET'])]
    public function index(SalleRepository $salleRepository): Response
    {    if ($this->isGranted('ROLE_ADMIN')) {
        return $this->render('admin_salle/index.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);}
        else{
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/new', name: 'app_admin_salle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {  if ($this->isGranted('ROLE_ADMIN')) {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salle);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_salle/new.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);}
        else{
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/{id}', name: 'app_admin_salle_show', methods: ['GET'])]
    public function show(Salle $salle): Response
    {  if ($this->isGranted('ROLE_ADMIN')) {
        return $this->render('admin_salle/show.html.twig', [
            'salle' => $salle,
        ]);}
        else{
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/{id}/edit', name: 'app_admin_salle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {   if ($this->isGranted('ROLE_ADMIN')) {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_salle/edit.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);}
        else{
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/{id}', name: 'app_admin_salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    { if ($this->isGranted('ROLE_ADMIN')) {
        if ($this->isCsrfTokenValid('delete'.$salle->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($salle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
    }
        else{
            return $this->redirectToRoute('app_home');
        }
    }

    #[ROUTE('/{id}/disponibilites', name:'app_admin_salle_disponibilites', methods: ['GET','POST'])]
    public function disponibilites($id,ReservationRepository $calendar,Request $request, SalleRepository $salle): Response
    {    
       
        if ($this->isGranted('ROLE_ADMIN')) {
            $events = $calendar->findAll();
            $rdvs = [];
          
          
            foreach($events as $event){
                $colorBg  = 'blue';
            
                if($event->getSalle()->getId() ==$id ){
                    $rdvs[] = [
                        'id' => $event->getId(),
                        'idSalle'=>$id,
                        'title'=>'Réservé par : ' .$event->getUser()->getNom() .'  '  .$event->getUser()->getPrenom(),
                        'start' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                        'end' => $event->getDateFin()->format('Y-m-d H:i:s'),                   
                        'backgroundColor' =>  $colorBg,
                        'borderColor' => $colorBg,
                        'textColor' => $event->getTextColor(),
                      
                    ];
                }
            } 
    
            $data = json_encode($rdvs);
    
            return $this->render('admin_salle/disponibilites.html.twig', 
            [
                'data' => $data,
                'id'=> $id,
            ]
            );
        }else {
            return $this->redirectToRoute('app_home');
        }
       
    }


}
