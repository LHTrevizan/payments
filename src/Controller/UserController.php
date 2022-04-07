<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Model\UserModel;

/**
 * @Route("/users", name="user_")
 * @SWG\Tag(name="Users")
 * @SWG\Response(response=200, description="OK")
 * @SWG\Response(response=401, description="Erro")
 */
class UserController extends AbstractController
{
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index(): Response
    {
        $users = $this->userModel->findAllUsers();

        if (empty($users)) {
            return new JsonResponse(['message' => 'not found users'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
        'data' => $users
        ]);
    }

    public function show($userId) {
        $user = $this->userModel->findUserById($userId);

        if (empty($user)) {
            return new JsonResponse(['message' => 'not found user'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
        'data' => $user
        ]);
    }

    public function create(Request $request) {
        return new JsonResponse($this->userModel->createUser($request->request->all()));
    }
}