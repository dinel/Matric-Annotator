<?php

namespace App\Entity;

use App\Repository\EvaluationTaskRepository;
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
}
