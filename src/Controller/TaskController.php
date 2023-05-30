<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    protected $entityManager;
    protected $taskRepository;

    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }

    #[Route('/tasks', name: 'task_list')]
    public function listAction(): Response
    {
        $tasks = $this->taskRepository->findAll();
        $userConnected = $this->getUser() ?? null;

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
            'user' => $userConnected
        ]);
    }

    #[Route('/tasks_completed', name: 'task_completed')]
    public function listActionCompleted(): Response
    {
        $tasks = $this->taskRepository->findByCompletedTask();

        return $this->render('task/list_completed.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route("/tasks/create", name: "task_create")]
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setIsDone(false);
            $task->setUserId($this->getUser() ?? null);
            $task->setCreatedAt(new \DateTime());
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route("/tasks/{id}/edit", name: "task_edit")]
    public function editAction($id, Task $task, Request $request)
    {
        $task = $this->taskRepository->find($id);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }


    #[Route("/tasks/{id}/toggle", name: "task_toggle")]
    public function toggleTaskAction($id)
    {
        $task = $this->taskRepository->find($id);

        $task->toggle(!$task->isIsDone());

        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }


    #[Route("/tasks/{id}/delete", name: "task_delete")]
    public function deleteTaskAction($id)
    {
        $task = $this->taskRepository->find($id);

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
