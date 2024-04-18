<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(SubscriptionTypeRepository $typeRepo): Response
    {
        $typeRepo = $typeRepo->findAll();
        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'typeRepo' => $typeRepo,
        ]);
    }
}
