<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
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
    private $bankBalance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankBalance(): ?string
    {
        return $this->bankBalance;
    }

    public function setBankBalance(string $bankBalance): self
    {
        $this->bankBalance = $bankBalance;

        return $this;
    }
}
