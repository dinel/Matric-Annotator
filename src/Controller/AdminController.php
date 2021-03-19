<?php

namespace App\Controller;

use App\Entity\EvaluationTask;
use App\Entity\Task4User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/index-tasks", name="admin-tasks")
     */
    public function indexAdminAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tasks = $entityManager->getRepository(EvaluationTask::class)->findAll();
        $usersPerTask = [];

        foreach($tasks as $task) {
            $users = $entityManager->getRepository(Task4User::class)
                ->findBy(['task' => $task]);
            $usersPerTask[$task->getId()] = array_map(function($a) { return $a->getUser()->getEmail(); }, $users);
        }

        return $this->render('admin/index-tasks.html.twig', [
            'tasks' => $tasks,
            'usersPerTask' => $usersPerTask,
        ]);
    }

}