<?php

namespace App\Entity;

use App\Repository\StandardUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandardUserRepository::class)
 */
class StandardUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $CPF;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCPF(): ?string
    {
        return $this->CPF;
    }

    public function setCPF(string $CPF): self
    {
        $this->CPF = $CPF;

        return $this;
    }
}
