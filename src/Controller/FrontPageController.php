<?php

namespace App\Controller;

use App\Entity\Task4User;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class FrontPageController extends AbstractController
{
    /**
     * @Route("/", name="front_page")
     */
    public function index(): Response
    {
        // if here reset the video offset
        $session = new Session();
        $session->start();
        $session->set("video-offset", "0");

        $user = $this->getUser();

        if (! $user) {
            return $this->redirectToRoute('app_login');
        }

        // check whether the user is still valid (probably completely unnecessary)
        if(! $this->isUserValid($user)) {
            return $this->redirectToRoute('app_logout');
        }

        // get the tasks for this user
        $entityManager = $this->getDoctrine()->getManager();
        $tasks = $entityManager->getRepository(Task4User::class)
            ->findBy(['user' => $user]);

        $info_tasks = [];
        foreach($tasks as $task) {
            $info_tasks[] = [$task, $task->getTask()->calculateCompleteness($entityManager, $user)];
        }

        return $this->render('front_page/index.html.twig', [
            'user' => $this->getUser(),
            'info_tasks' => $info_tasks,
        ]);
    }

    private function isUserValid(User $user): bool
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userDatabase = $entityManager->getRepository(User::class)
                ->find($user->getId());
        if($userDatabase) {
            return true;
        } else {
            return false;
        }
    }
}
