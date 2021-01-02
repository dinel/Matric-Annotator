<?php

namespace App\Controller;

use App\Entity\SegmentPair;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class AnnotationController extends AbstractController
{
    /**
     * @Route("/annotation/{id}", name="annotation", requirements={"id"="\d+"})
     */
    public function index(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $segment = $entityManager->getRepository(SegmentPair::class)
                                 ->find($id);
        $task = $segment->getTask();

        $session = new Session();
        $session->start();
        $position = $session->get("position", "right");

        return $this->render('annotation/index.html.twig', [
            'segment' => $segment,
            'task' => $task,
            'position' => $position,
        ]);
    }

    /**
     * @Route("/annotation/move-preview")
     */
    public function movePreviewAction(): Response
    {
        $session = new Session();
        $session->start();

        $position = $session->get("position", "right");
        if($position === "right") {
            $session->set("position", "left");
        } else {
            $session->set("position", "right");
        }

        return new JsonResponse(true);
    }
}
