<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Repository\EquipementRepository;
use App\Repository\SalleRepository;
use Symfony\Component\BrowserKit\Request;
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
}
