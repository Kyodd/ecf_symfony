<?php

namespace App\Controller;

use App\Entity\Prets;
use App\Form\PretsType;
use App\Repository\PretsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/prets/admin')]
class PretsAdminController extends AbstractController
{
    #[Route('/', name: 'app_prets_admin_index', methods: ['GET'])]
    public function index(PretsRepository $pretsRepository): Response
    {
        return $this->render('prets_admin/index.html.twig', [
            'prets' => $pretsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prets_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pret = new Prets();
        $form = $this->createForm(PretsType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pret);
            $entityManager->flush();

            return $this->redirectToRoute('app_prets_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prets_admin/new.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prets_admin_show', methods: ['GET'])]
    public function show(Prets $pret): Response
    {
        return $this->render('prets_admin/show.html.twig', [
            'pret' => $pret,
        ]);
    }

   

    #[Route('/{id}', name: 'app_prets_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Prets $pret, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pret->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($pret);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prets_admin_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/comment', name: 'app_prets_admin_comment', methods: ['POST'])]
public function comment(Request $request, Prets $pret, EntityManagerInterface $entityManager): Response
{
    $commentaire = $request->request->get('commentaire');
    $pret->setCommentaire($commentaire);
    
    $entityManager->persist($pret);
    $entityManager->flush();

    // Rediriger vers la page de détails du prêt
    return $this->redirectToRoute('app_prets_admin_show', ['id' => $pret->getId()]);
}
}
