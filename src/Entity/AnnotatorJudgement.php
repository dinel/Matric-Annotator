<?php

namespace App\Entity;

use App\Repository\AnnotatorJudgementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnotatorJudgementRepository::class)
 */
class AnnotatorJudgement
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
    private $q_st1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q_st2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $substitution_distortion_rate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $step2_explanation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q_st3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $omission_distortion_rate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $step3_explanation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q_st4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addition_distortion_rate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $step4_explanation;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="SegmentPair")
     * @ORM\JoinColumn(name="pair_id", referencedColumnName="id")
     */
    private $pair;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQSt1()
    {
        return $this->q_st1;
    }

    /**
     * @param mixed $q_st1
     */
    public function setQSt1($q_st1): void
    {
        $this->q_st1 = $q_st1;
    }

    /**
     * @return mixed
     */
    public function getQSt2()
    {
        return $this->q_st2;
    }

    /**
     * @param mixed $q_st2
     */
    public function setQSt2($q_st2): void
    {
        $this->q_st2 = $q_st2;
    }

    /**
     * @return mixed
     */
    public function getSubstitutionDistortionRate()
    {
        return $this->substitution_distortion_rate;
    }

    /**
     * @param mixed $substitution_distortion_rate
     */
    public function setSubstitutionDistortionRate($substitution_distortion_rate): void
    {
        $this->substitution_distortion_rate = $substitution_distortion_rate;
    }

    /**
     * @return mixed
     */
    public function getStep2Explanation()
    {
        return $this->step2_explanation;
    }

    /**
     * @param mixed $step2_explanation
     */
    public function setStep2Explanation($step2_explanation): void
    {
        $this->step2_explanation = $step2_explanation;
    }

    /**
     * @return mixed
     */
    public function getQSt3()
    {
        return $this->q_st3;
    }

    /**
     * @param mixed $q_st3
     */
    public function setQSt3($q_st3): void
    {
        $this->q_st3 = $q_st3;
    }

    /**
     * @return mixed
     */
    public function getOmissionDistortionRate()
    {
        return $this->omission_distortion_rate;
    }

    /**
     * @param mixed $omission_distortion_rate
     */
    public function setOmissionDistortionRate($omission_distortion_rate): void
    {
        $this->omission_distortion_rate = $omission_distortion_rate;
    }

    /**
     * @return mixed
     */
    public function getStep3Explanation()
    {
        return $this->step3_explanation;
    }

    /**
     * @param mixed $step3_explanation
     */
    public function setStep3Explanation($step3_explanation): void
    {
        $this->step3_explanation = $step3_explanation;
    }

    /**
     * @return mixed
     */
    public function getQSt4()
    {
        return $this->q_st4;
    }

    /**
     * @param mixed $q_st4
     */
    public function setQSt4($q_st4): void
    {
        $this->q_st4 = $q_st4;
    }

    /**
     * @return mixed
     */
    public function getAdditionDistortionRate()
    {
        return $this->addition_distortion_rate;
    }

    /**
     * @param mixed $addition_distortion_rate
     */
    public function setAdditionDistortionRate($addition_distortion_rate): void
    {
        $this->addition_distortion_rate = $addition_distortion_rate;
    }

    /**
     * @return mixed
     */
    public function getStep4Explanation()
    {
        return $this->step4_explanation;
    }

    /**
     * @param mixed $step4_explanation
     */
    public function setStep4Explanation($step4_explanation): void
    {
        $this->step4_explanation = $step4_explanation;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPair()
    {
        return $this->pair;
    }

    /**
     * @param mixed $pair
     */
    public function setPair($pair): void
    {
        $this->pair = $pair;
    }
}
