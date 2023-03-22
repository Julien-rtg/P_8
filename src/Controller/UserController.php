<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    protected $entityManager;
    protected $userRepository;
    protected $passwordHasher;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/users', name: 'user_list')]
    public function index(): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $this->userRepository->findAll()
        ]);
    }

    #[Route("/users/create", name: "user_create")]
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plaintextPassword = $user->getPassword();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route("/users/{id}/edit", name: "user_edit")]
    public function editAction($id, Request $request)
    {

        $user = $this->userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plaintextPassword = $user->getPassword();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    #[Route("/users/{id}/delete", name: "user_delete")]
    public function deleteAction($id)
    {

        $user = $this->userRepository->find($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', "L'utilisateur à bien été supprimé");

        return $this->redirectToRoute('user_list');
        

    }


}
