<?php

namespace App\Entity;

use App\Repository\EvaluationTaskRepository;
use App\Entity\SegmentPair;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationTaskRepository::class)
 */
class EvaluationTask
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $src_lang;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trg_lang;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $video;

    /**
     * One annotation task has many segments
     * @ORM\OneToMany(targetEntity="SegmentPair", mappedBy="task")
     */
    private $segments;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $title;

    public function __construct()
    {
        $this->segments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSrcLang(): ?string
    {
        return $this->src_lang;
    }

    public function setSrcLang(string $src_lang): self
    {
        $this->src_lang = $src_lang;

        return $this;
    }

    public function getTrgLang(): ?string
    {
        return $this->trg_lang;
    }

    public function setTrgLang(string $trg_lang): self
    {
        $this->trg_lang = $trg_lang;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getSegments()
    {
        return $this->segments;
    }

    public function addSegmentPair(SegmentPair $pair): self
    {
        $this->segments[] = $pair;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFirst(): int
    {
        return $this->segments[0]->getId();
    }
}
