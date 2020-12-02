<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnotationController extends AbstractController
{
    /**
     * @Route("/annotation", name="annotation")
     */
    public function index(): Response
    {
        return $this->render('annotation/index.html.twig', [
            'controller_name' => 'AnnotationController',
        ]);
    }
}
