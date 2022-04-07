<?php

namespace App\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionsRepository;
use App\Repository\UserTypeRepository;
use App\Repository\UserRepository;
use App\Entity\UserType;
use App\Entity\User;


Class UserModel
{
    public function __construct(UserRepository $repository, UserTypeRepository $userTypeRepository, EntityManagerInterface $em)
    {
        $this->repository         = $repository;
        $this->userTypeRepository = $userTypeRepository;
        $this->em                 = $em;
    }

    public function findAllUsers() {
        return $this->repository->findAll();
    }

    public function findUserById($userId) {
        return $this->repository->findOneById($userId);
    }

    public function createUser(array $data)
    {
        $user     = new User();
        $userType = $this->userTypeRepository->findOneById($data['userType']);

        $this->validateShopkeeper($userType, $data);
        $this->validateStandard($userType,  $data);

        try {
            if ($userType->getName() === 'Normal') {
                $user->setCPF($data['CPF']);
            } else {
                $user->setCNPJ($data['CNPJ']);
            }
        } catch(\Exception $e) {
            throw new \Exception("not found CNPJ", 404);
        }

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setBankBalance($data['bankBalance']);
        $user->setUserType($userType);
        $user->setUpdatedAt(new \DateTime());
        $user->setCreatedAt(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        return ['message' => 'Usuario criado com sucesso!'];
    }

    public function validateStandard(UserType $userType, array $data)
    {
        if ($userType->getName() === 'Normal') {
            if (empty($data['CPF'])) {
                throw new \Exception("not found CPF", 404);
            }

            if(!empty($this->repository->findBy(['CPF' => $data['CPF']]))) {
                throw new \Exception("CPF already exist", 409);
            }
        }
    }

    public function validateShopkeeper(UserType $userType, array $data)
    {
        if ($userType->getName() === 'Lojista') {
            if (empty($data['CNPJ'])) {
                throw new \Exception("not found CNPJ", 404);
            }

            if(!empty($this->repository->findBy(['CNPJ' => $data['CNPJ']]))) {
                throw new \Exception("CNPJ already exist", 409);
            }
        }
    }
}