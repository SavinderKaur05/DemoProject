<?php

namespace App\Entity;

use App\Repository\StudentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentsRepository::class)]
class Students
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\Column(type: 'string', length: 255)]
    private $Admission_Number;

    #[ORM\ManyToOne(targetEntity: Classes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $class;

    #[ORM\OneToOne(targetEntity: Users::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
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

    public function getClass(): ?Classes
    {
        return $this->class;
    }

    public function setClass(?Classes $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(Users $User): self
    {
        $this->User = $User;

        return $this;
    }
}
