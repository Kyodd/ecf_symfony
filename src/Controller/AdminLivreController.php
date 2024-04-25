<?php

namespace App\Controller;

use DateTime;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Repository\PretsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Prets; // Importez la classe Prets
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/admin/livre')]
class AdminLivreController extends AbstractController
{
    #[Route('/', name: 'app_admin_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository,  PretsRepository $pretRepos): Response
    {    
        if (!$this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('app_home');
    }
        
          
        $livres = $livreRepository->findAll(); // Récupérer tous les livres
        $pretsEnCours= $pretRepos->findPrets();// Récupérer tous les livres
       
        return $this->render('admin_livre/index.html.twig', [
            'livres' => $livres,
            "pret"=>$pretsEnCours
            
        ]);
        
    }
     #[Route('/en_retard', name: 'app_admin_livre_en_retard', methods: ['GET'])]
    public function livresEnRetard(LivreRepository $livreRepository, PretsRepository $pretRepos): Response
    {
        // Récupérer les livres en retard depuis le repository
        $livresEnRetard = $livreRepository->findLivresEnRetard();
        $date = new DateTime();
        // Récupérer les prêts en cours pour chaque livre en retard
        $pretsEnCours = [];
        foreach ($livresEnRetard as $livre) {
            $pretsEnCours[$livre->getId()] = $pretRepos->findPrets($livre->getId());
        }

        return $this->render('admin_livre/retard.html.twig', [
            'livres' => $livresEnRetard,
            'pret' => $pretsEnCours,
            'datetoday' => $date
        ]);
    }

    #[Route('/rendu/{id}', name: 'app_admin_livre_rendu', methods: ['POST'])]
    public function enregistrerRendu( $id, Request $request, EntityManagerInterface $entityManager, PretsRepository $pretRepos): Response
    {
        // Récupérer le livre correspondant à l'ID
        $livre = $entityManager->getRepository(Livre::class)->find($id);
     

        // Vérifier si le livre existe
        if (!$livre) {
            throw $this->createNotFoundException('Livre non trouvé');
        }
        $livre->setDisponibilite(true);
        $pretsEnCours= $pretRepos->findPrets();// Récupérer tous les livres

        foreach($pretsEnCours as $pret){
            if($pret->getLivre()->getId()==$livre->getId())
            {
                $pret->setDateRendu(new DateTime());


                $entityManager->persist($pret);
                $entityManager->flush();
            }

        }
      

        // Enregistre les modifications dans la base de données
     

        // Redirige vers la page d'accueil des livres avec message 
        $this->addFlash('success', 'La date de rendu a été enregistrée avec succès.');

        return $this->redirectToRoute('app_admin_livre_index');
    }




         

    #[Route('/new', name: 'app_admin_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('admin_livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
