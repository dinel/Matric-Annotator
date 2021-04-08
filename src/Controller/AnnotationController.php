<?php

namespace App\Controller;

use App\Entity\AnnotatorJudgement;
use App\Entity\SegmentPair;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class AnnotationController extends AbstractController
{
    /**
     * @Route("/annotation-new/{id}", name="annotation-new", requirements={"id"="\d+"})
     */
    public function indexNewAction(int $id)
    {
        return $this->render('annotation/index-new.html.twig', [
            'render' => "Hello {{ name }}",
            'name' => 'Dinel',
        ]);
    }

    /**
     * @Route("/annotation/{id}", name="annotation", requirements={"id"="\d+"})
     */
    public function indexAction(int $id): Response
    {
        $session = new Session();
        $session->start();
        $position = $session->get("position", "right");
        $videoOffset = $session->get("video-offset", "0");

        // TODO: check the user is valid and has access to this task

        $segment = $this->getSegmentById($id);
        $task = $segment->getTask();
        $user = $this->getUser();

        $segments = $task->getSegments();
        $pos = $segments->indexOf($segment);

        $em = $this->getDoctrine()->getManager();
        $annotation = $segment->findAnnotationByUser($em, $user);
        $completeness = $task->calculateCompleteness($em, $user);

        return $this->render('annotation/index.html.twig', [
            'segment' => $segment,
            'task' => $task,
            'position' => $position,
            'user' => $this->getUser(),
            'annotation' => $annotation,
            'pos' => $pos + 1,
            'complete' => $completeness[0],
            'total' => $completeness[1],
            'offset' => $videoOffset,
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

    /**
     * @Route ("/annotation/set-offset/{offset}")
     */
    public function setOffsetAction($offset): Response
    {
        $session = new Session();
        $session->start();
        $session->set("video-offset", $offset);

        return new JsonResponse(true);
    }

    /**
     * @Route("/annotation/save_evaluation", name="save_evaluation", methods={"POST"})
     */
    public function saveEvaluationAction(Request $request): Response
    {
        if(! $request->isXMLHttpRequest()) {
            // TO DO: probably redirection to a different page
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
                400);
        } else {
            $data = $request->get('data');

            if($data) {
                if(! array_key_exists("id", $data)) {
                    $annotation = new AnnotatorJudgement();
                } else {
                    $annotation = $this->getAnnotationById($data["id"]);

                    if(! $annotation) {
                        return new JsonResponse(array(
                            'status' => 'Error',
                            'message' => 'Invalid AnnotatorJudgement ID received'),
                            400);
                    }
                }

                $annotation->setPair($this->getSegmentById($data["segment"]));
                $annotation->setUser($this->getUserById($data["user"]));
                $this->copyJudgements($annotation, $data);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($annotation);
                $manager->flush();

                return new JsonResponse(array(
                    'status' => 'Success',
                    'id' => $annotation->getId()),
                    200);
            } else {
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'No data received'),
                    400);
            }
        }
    }

    private function copyJudgements(AnnotatorJudgement $obj, $data) {
        if(array_key_exists("q_st1", $data)) $obj->setQSt1($data["q_st1"]);

        if(array_key_exists("q_st2", $data)) $obj->setQSt2($data["q_st2"]);
        if(array_key_exists("substitution-distortion-rate", $data))
            $obj->setSubstitutionDistortionRate($data["substitution-distortion-rate"]);
        if(array_key_exists("step2-explanation", $data)) $obj->setStep2Explanation($data["step2-explanation"]);

        if(array_key_exists("q_st3", $data)) $obj->setQSt3($data["q_st3"]);
        if(array_key_exists("omission-distortion-rate", $data))
            $obj->setOmissionDistortionRate($data["omission-distortion-rate"]);
        if(array_key_exists("step3-explanation", $data)) $obj->setStep3Explanation($data["step3-explanation"]);

        if(array_key_exists("q_st4", $data)) $obj->setQSt4($data["q_st4"]);
        if(array_key_exists("addition-distortion-rate", $data))
            $obj->setAdditionDistortionRate($data["addition-distortion-rate"]);
        if(array_key_exists("step4-explanation", $data)) $obj->setStep4Explanation($data["step4-explanation"]);
    }

    /**
     * Helper function to retrieve the segment corresponding to an ID
     * @param int $id the ID of the segment
     * @return SegmentPair the segment with the given ID
     */
    private function getSegmentById(int $id): SegmentPair
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager->getRepository(SegmentPair::class)->find($id);
    }

    /**
     * Helper function to retrieve the user corresponding to an ID
     * @param int $id the ID of the user
     * @return User the user with the given ID
     */
    private function getUserById(int $id): User
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager->getRepository(User::class)->find($id);
    }

    /**
     * Helper function to retrieve the annotation corresponding to an ID
     * @param int $id the ID of the annotation
     * @return AnnotatorJudgement the annotation with the given ID
     */
    private function getAnnotationById(int $id): AnnotatorJudgement
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager->getRepository(AnnotatorJudgement::class)->find($id);
    }


    private function getAnnotation(SegmentPair $segment, User $user): ?AnnotatorJudgement
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(AnnotatorJudgement::class);
        return $repository->findOneBy(['user' => $user, 'pair' => $segment]);
    }
}
