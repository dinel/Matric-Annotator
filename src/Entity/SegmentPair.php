<?php

namespace App\Entity;

use App\Repository\SegmentPairRepository;
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
}
