<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/admin')]
class UserAdminController extends AbstractController
{
    #[Route('/', name: 'app_user_admin_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user_admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_admin_show', methods: ['GET'])]
    public function show(User $user, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $livre = $doctrine->getRepository(User::class)->find($user->getId());

        if($user && $user->isBanned()){
            return $this->redirectToRoute('app_ban');
        }

        if($this->getUser()->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user_admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_admin_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if($user && $user->isBanned()){
    //         return $this->redirectToRoute('app_ban');
    //     }

    //     if($this->getUser()->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN')){
    //         return $this->redirectToRoute('app_home');
    //     }

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_user_admin_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('user_admin/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser()->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', ['id' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
