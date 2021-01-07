<?php

namespace App\Entity;

use App\Repository\SegmentPairRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SegmentPairRepository::class)
 */
class SegmentPair
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $target;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $offset;

    /**
     * Many segments belong to an EvaluationTask
     * @ORM\ManyToOne(targetEntity="EvaluationTask", inversedBy="segments")
     * @ORM\JoinColumn(name="segment_id", referencedColumnName="id")
     */
    private $task;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prev;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $next;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function getTask(): EvaluationTask
    {
        return $this->task;
    }

    public function setTask(EvaluationTask $task): self
    {
        $this->task = $task;
        $task->addSegmentPair($this);

        return $this;
    }

    public function getPrev(): ?int
    {
        return $this->prev;
    }

    public function setPrev(?int $prev): self
    {
        $this->prev = $prev;

        return $this;
    }

    public function getNext(): ?int
    {
        return $this->next;
    }

    public function setNext(?int $next): self
    {
        $this->next = $next;

        return $this;
    }

    public function findAnnotationByUser(EntityManager $entityManager, User $user): ?AnnotatorJudgement
    {
        $repository = $entityManager->getRepository(AnnotatorJudgement::class);
        return $repository->findOneBy(['user' => $user, 'pair' => $this]);
    }
}
