<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TransactionsRepository;
use App\Repository\UserRepository;
use App\Entity\ Transactions;
use App\Entity\User;
use App\Repository\UserTypeRepository;
use App\Service\Mocks;
use App\Model\TransactionsModel;

use Guzzle\Http\Client;
use Swagger\Annotations as SWG;

/**
  * @Route("/transactions", name="transaction_")
  * @SWG\Tag(name="Transactions")
  * @SWG\Response(response=200, description="OK")
  * @SWG\Response(response=401, description="Erro")
  */

class TransactionsController extends AbstractController
{
  public function __construct(TransactionsModel $transactionsModel)
  {
    $this->transactionsModel = $transactionsModel;
  }

  public function index(): Response
  {
    $transactions = $this->transactionsModel->findAllTransaction();

    if (empty($transactions)) {
      return new JsonResponse(['message' => 'not found transactions'], Response::HTTP_NOT_FOUND);
    }

    return $this->json([
      'data' => $transactions
    ]);
  }

  public function show($transactionId) {

    $transaction = $this->transactionsModel->findTransactionById($transactionId);

    if (empty($transaction)) {
      return new JsonResponse(['message' => 'not found transaction'], Response::HTTP_NOT_FOUND);
    }

    return $this->json([
      'data' => $transaction
    ]);
  }

  public function createTransaction(Request $request) {
    return new JsonResponse($this->transactionsModel->transaction($request->request->all()));
  }

  public function createRefound(Int $transactionId)
  {
    return new JsonResponse($this->transactionsModel->refound($transactionId));
  }

}
