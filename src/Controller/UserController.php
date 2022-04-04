<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;


/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
  public function __construct(UserRepository $repository)
  {
      $this->repository = $repository;
  }

  /**
   * @Route("/", name="index", methods={"GET"})
   */
    public function index(): Response
    {
      $users = $this->repository->findAll();

      return $this->json([
        'data' => $users
      ]);
    }

    /**
   * @Route("/{userId}", name="show", methods={"GET"})
   */

   public function show($userId,  Request $request) {
    $data = $request->request->all();

    $user = $this->repository->findOneBy(['id' => $userId]);

    return $this->json([
      'data' => $user
    ]);
   }

      /**
   * @Route("/", name="create", methods={"POST"})
   */

  public function create(Request $request) {
    $data = $request->request->all();

    $user = new User();
    $user->setName($data['name']);
    $user->setUserType($data['userType']);

    $doctrine = $this->getDoctrine()->getManager();

    $doctrine->persist($user);
    $doctrine->flush();
    return $this->json([
      'data' => 'Usuario criado com suceso!'
    ]);
  }

  /**
   * @Route("/{userId}", name="update", methods={"PUT", "PATH"})
   */

  public function update($userId, Request $request) {
    $data = $request->request->all();

    $user = $this->repository->findOneBy(['id' =>$userId]);
    $user->setName($data['name']);
    $user->setUserType($data['userType']);

    $doctrine = $this->getDoctrine()->getManager();

    $doctrine->flush();
    return $this->json([
      'data' => 'Usuario atualizado com sucesso!'
    ]);
  }

  /**
   * @Route("/{userId}", name="delete", methods={"DELETE"})
   */

  public function delete($userId, Request $request) {
    $data = $request->request->all();

    $doctrine = $this->getDoctrine()->getManager();

    $user = $this->repository->findOneBy(['id' => $userId]);

    $doctrine->remove($user);
    $doctrine->flush();

    return $this->json([
      'data' => 'Usuario deletado com sucesso!'
    ]);
  }
}
