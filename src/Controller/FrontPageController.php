<?php

namespace App\Controller;

use App\Entity\Task4User;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPageController extends AbstractController
{
    /**
     * @Route("/", name="front_page")
     */
    public function index(): Response
    {
        if (! $this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // check whether the user is still valid (probably completely unnecessary)
        if(! $this->isUserValid($this->getUser())) {
            return $this->redirectToRoute('app_logout');
        }

        // get the tasks for this user
        $entityManager = $this->getDoctrine()->getManager();
        $tasks = $entityManager->getRepository(Task4User::class)
            ->findBy(['user' => $this->getUser()]);

        return $this->render('front_page/index.html.twig', [
            'user' => $this->getUser(),
            'tasks' => $tasks,
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
