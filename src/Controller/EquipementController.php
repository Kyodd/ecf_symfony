<?php

namespace App\Controller;

use App\Repository\SalleRepository;
use App\Repository\EquipementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EquipementController extends AbstractController
{
    #[Route('/equipement', name: 'app_equipement')]
    public function index( EquipementRepository $equiRepo ): Response
    {

        $equipements = $equiRepo ->findAll();
        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }
}
