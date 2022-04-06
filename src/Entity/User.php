<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)

  * @ORM\Table(
  *     name="user",
  *     uniqueConstraints={
  *         @ORM\UniqueConstraint(columns={"CPF"}),
  *         @ORM\UniqueConstraint(columns={"CNPJ"}),
  *         @ORM\UniqueConstraint(columns={"email"})
  *     },
  *   )
  */

class User
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   * @Groups("user")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups("user")
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=15)
   */
  private $password;

  /**
   * @ORM\Column(type="float", options={"default": "0.0"}, nullable=true)
   */
  private $bankBalance;

  /**
   * @var \DateTime The creation date
   *
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(type="datetime", nullable=false)
   */
  private $updatedAt;

  /**
   * @var \DateTime The creation date
   *
   *@ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
   */
  private $createdAt;

  /**
   * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="payer")
   */
  private $transactionPayer;

  /**
   * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="payee")
   */
  private $transactionPayee;

  /**
   * @ORM\ManyToOne(targetEntity=UserType::class, cascade={"persist", "remove"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $userType;

  /**
   * @ORM\Column(type="string", length=15, nullable=true)
   */
  private $CNPJ;

  /**
   * @ORM\Column(type="string", length=15, nullable=true)
   */
  private $CPF;

  public function __construct()
  {
      $this->transactions     = new ArrayCollection();
      $this->transactionPayer = new ArrayCollection();
      $this->transactionPayee = new ArrayCollection();
  }

  public function getId(): ?int
  {
      return $this->id;
  }

  public function getName(): ?string
  {
      return $this->name;
  }

  public function setName(string $name): self
  {
      $this->name = $name;

      return $this;
  }

  public function getEmail(): ?string
  {
      return $this->email;
  }

  public function setEmail(string $email): self
  {
      $this->email = $email;

      return $this;
  }

  public function getPassword(): ?string
  {
      return $this->password;
  }

  public function setPassword(string $password): self
  {
      $this->password = $password;

      return $this;
  }

  public function getUpdatedAt(): ?\DateTime
  {
      return $this->updatedAt;
  }

  public function setUpdatedAt(?\DateTime $updatedAt): self
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }

  public function getCreatedAt(): ?\DateTime
  {
      return $this->createdAt;
  }

  public function setCreatedAt(\DateTime $createdAt): self
  {
      $this->createdAt = $createdAt;

      return $this;
  }

  /**
   * @return Collection<int, Transactions>
   */
  public function getTransactionPayer(): Collection
  {
      return $this->transactionPayer;
  }

  public function addTransactionPayer(Transactions $transactionPayer): self
  {
      if (!$this->transactionPayer->contains($transactionPayer)) {
          $this->transactionPayer[] = $transactionPayer;
          $transactionPayer->setPayer($this);
      }

      return $this;
  }

  public function removeTransactionPayer(Transactions $transactionPayer): self
  {
      if ($this->transactionPayer->removeElement($transactionPayer)) {
          // set the owning side to null (unless already changed)
          if ($transactionPayer->getPayer() === $this) {
              $transactionPayer->setPayer(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Transactions>
   */
  public function getTransactionPayee(): Collection
  {
      return $this->transactionPayee;
  }

  public function addTransactionPayee(Transactions $transactionPayee): self
  {
      if (!$this->transactionPayee->contains($transactionPayee)) {
          $this->transactionPayee[] = $transactionPayee;
          $transactionPayee->setPayee($this);
      }

      return $this;
  }

  public function removeTransactionPayee(Transactions $transactionPayee): self
  {
      if ($this->transactionPayee->removeElement($transactionPayee)) {
          // set the owning side to null (unless already changed)
          if ($transactionPayee->getPayee() === $this) {
              $transactionPayee->setPayee(null);
          }
      }

      return $this;
  }

  public function getBankBalance(): ?float
  {
      return $this->bankBalance;
  }

  public function setBankBalance(float $bankBalance): self
  {
      $this->bankBalance = $bankBalance;

      return $this;
  }

  public function getUserType(): ?UserType
  {
      return $this->userType;
  }

  public function setUserType(UserType $userType): self
  {
      $this->userType = $userType;

      return $this;
  }

  public function getCNPJ(): ?string
  {
      return $this->CNPJ;
  }

  public function setCNPJ(?string $CNPJ): self
  {
      $this->CNPJ = $CNPJ;

      return $this;
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
