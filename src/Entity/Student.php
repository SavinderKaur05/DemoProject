<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Admission_Number;

    #[ORM\ManyToOne(targetEntity: Classes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $ClassId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmissionNumber(): ?string
    {
        return $this->Admission_Number;
    }

    public function setAdmissionNumber(string $Admission_Number): self
    {
        $this->Admission_Number = $Admission_Number;

        return $this;
    }

    public function getClassId(): ?Classes
    {
        return $this->ClassId;
    }

    public function setClassId(?Classes $ClassId): self
    {
        $this->ClassId = $ClassId;

        return $this;
    }
}
