<?php

namespace App\Controller;

use DateTime;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use App\Repository\PretsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Prets; // Importez la classe Prets
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Importez la classe Request

class LivreController extends AbstractController
{
    #[Route('/livres', name: 'app_livre')]
    public function index(LivreRepository $livreRepository, PretsRepository $pretRepos): Response
    {
        // if (!$this->isGranted('ROLE_USER')) {
        //     return $this->redirectToRoute('app_home');
        // }

        $livres = $livreRepository->findAll(); // Récupérer tous les livres
        $pretsEnCours= $pretRepos->findPrets();
       
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            "pret"=>$pretsEnCours
        ]);

    
    }

    #[Route('/livre/{id}', name: 'app_livre_show')]
    public function show(Livre $livre, PretsRepository $pretRepos): Response
    {
        // Récupérer les prêts en cours pour ce livre
        $pretsEnCours = $pretRepos->findPrets($livre);
    
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'prets' => $pretsEnCours,
        ]);
    }
    
 
    #[Route('/livre/{id}/reservation', name: 'reservation')]
public function reservation(Livre $livre, Request $request, ManagerRegistry $doctrine): Response
{
    // Logique de réservation du livre
    
    // Vérifie si l'utilisateur est connecté
    if (!$this->getUser()) {
        // Si l'utilisateur n'est pas connecté, redirigez vers la page de connexion
        return $this->redirectToRoute('login');
    }

    // Étape 2 : Enregistrez la réservation du livre dans la base de données
// Récupérer le manager de l'entité pour pouvoir enregistrer la réservation
$entityManager = $doctrine->getManager();

// Créez une nouvelle instance de l'entité Prets pour représenter la réservation
$prets = new Prets();

// Définissez les détails de la réservation
// Date de début de la réservation
$dateDebut = new DateTime();
$prets->setDateDebut($dateDebut);




// Date de fin de la réservation (6 jours plus tard)
$dateFin = (clone $dateDebut)->modify("+6 day");
$prets->setDateFin($dateFin);




// Associez le livre à la réservation
$prets->setLivre($livre);

// Associez l'utilisateur à la réservation
$prets->setUser($this->getUser());
$prets->setExtension(false);
// Mettre à jour la disponibilité du livre
$livre->setDisponibilite(false);



// Enregistrer les changements dans la base de données
$entityManager->persist($prets);
$entityManager->flush();

// Étape 3 : Redirigez l'utilisateur vers la page de détail du livre
return $this->redirectToRoute('app_livre_show', ['id' => $livre->getId()]);

}


    
    
}    