<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:'Employee Code cannot be empty')]
    private $employeeCode;

    #[ORM\OneToOne(targetEntity: Users::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeCode(): ?string
    {
        return $this->employeeCode;
    }

    public function setEmployeeCode(string $employeeCode): self
    {
        $this->employeeCode = $employeeCode;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(Users $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
