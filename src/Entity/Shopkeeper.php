<?php

namespace App\Entity;

use App\Repository\ShopkeeperRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopkeeperRepository::class)
 */
class Shopkeeper
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
    private $CNPJ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCNPJ(): ?string
    {
        return $this->CNPJ;
    }

    public function setCNPJ(string $CNPJ): self
    {
        $this->CNPJ = $CNPJ;

        return $this;
    }
}
