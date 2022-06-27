<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EmployeesRepository;

#[ORM\Entity(repositoryClass: EmployeesRepository::class)]
class Employees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $EmployeeCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $User;

    #[ORM\Column(type: 'string', length: 255)]
    private $Role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeCode(): ?string
    {
        return $this->EmployeeCode;
    }

    public function setEmployeeCode(string $EmployeeCode): self
    {
        $this->EmployeeCode = $EmployeeCode;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }
}
