<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\UserTypeRepository;
use App\Entity\UserType;
use App\Entity\User;
use Swagger\Annotations as SWG;

/**
 * @Route("/users", name="user_")
 * @SWG\Tag(name="Users")
 * @SWG\Response(response=200, description="OK")
 * @SWG\Response(response=401, description="Erro")
 */
class UserController extends AbstractController
{
  public function __construct(UserRepository $repository, UserTypeRepository $userTypeRepository)
  {
    $this->repository         = $repository;
    $this->userTypeRepository = $userTypeRepository;
  }

  public function index(): Response
  {
    $users = $this->repository->findAll();

    if (empty($users)) {
      return new JsonResponse(['message' => 'not found users'], Response::HTTP_NOT_FOUND);
    }

    return $this->json([
      'data' => $users
    ]);
  }

  public function show($userId) {
    $user = $this->repository->findOneById($userId);

    if (empty($user)) {
      return new JsonResponse(['message' => 'not found user'], Response::HTTP_NOT_FOUND);
    }

    return $this->json([
      'data' => $user
    ]);
  }

  public function create(Request $request) {
    $data = $request->request->all();
    $user = new User();
    $userType = $this->userTypeRepository->findOneById($data['userType']);

    $this->validateShopkeeper($userType, $request);
    $this->validateStandard($userType,  $request);

    try {
      if ($userType->getName() === 'Normal') {
        $user->setCPF($data['CPF']);
      } else {
        $user->setCNPJ($data['CNPJ']);
      }
    } catch(\Exception $e) {
      return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
    }

    $user->setName($data['name']);
    $user->setEmail($data['email']);
    $user->setPassword($data['password']);
    $user->setBankBalance($data['bankBalance']);
    $user->setUserType($userType);
    $user->setUpdatedAt(new \DateTime());
    $user->setCreatedAt(new \DateTime());

    $doctrine = $this->getDoctrine()->getManager();
    $doctrine->persist($user);
    $doctrine->flush();

    return new JsonResponse(['message' => 'Usuario criado com sucesso!'], Response::HTTP_CREATED);
  }

  public function update($userId, Request $request) {
    $data = $request->request->all();
    $user = $this->repository->findOneById($userId);
    $userType = $this->userTypeRepository->findOneById($data['userType']);

    $this->validateShopkeeper($userType, $request);
    $this->validateStandard($userType,  $request);

    try {
      if ($userType->getName() === 'Normal') {
        $user->setCPF($data['CPF']);
      } else {
        $user->setCNPJ($data['CNPJ']);
      }
    } catch(\Exception $e) {
        return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
    }

    $user->setName($data['name']);
    $user->setEmail($data['email']);
    $user->setPassword($data['password']);
    $user->setBankBalance($data['bankBalance']);
    $user->setUserType($userType);
    $user->setUpdatedAt(new \DateTime());
    $user->setCreatedAt(new \DateTime());

    $doctrine = $this->getDoctrine()->getManager();

    $doctrine->flush();
    return new JsonResponse(['message' => 'Usuario atualizado com sucesso!'], Response::HTTP_OK);
  }

  public function delete($userId) {
    $doctrine = $this->getDoctrine()->getManager();
    $user = $this->repository->findOneById($userId);

    if (empty($user)) {
      return new JsonResponse(['message' => 'not found user'], Response::HTTP_NOT_FOUND);
    }

    $doctrine->remove($user);
    $doctrine->flush();

    return $this->json([
      'data' => 'Usuario deletado com sucesso!'
    ]);
  }

  public function validateStandard(UserType $userType, Request $request)
  {
    $data = $request->request->all();

    if ($userType->getName() === 'Normal') {
      if (empty($data['CPF'])) {
        throw new Exception("not found CPF", 404);
      }

      if(!empty($this->repository->findBy(['CPF' => $data['CPF']]))) {
        throw new Exception("CPF already exist", 409);
      }
    }
  }

  public function validateShopkeeper(UserType $userType, Request $request)
  {
    $data = $request->request->all();

    if ($userType->getName() === 'Lojista') {
      if (empty($data['CNPJ'])) {
        throw new Exception("not found CNPJ", 404);
      }

      if(!empty($this->repository->findBy(['CNPJ' => $data['CNPJ']]))) {
        throw new Exception("CNPJ already exist", 409);
      }
    }
  }
}