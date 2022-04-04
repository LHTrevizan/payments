<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TransactionsRepository;
use App\Entity\Transactions;

/**
 * @Route("/transaction", name="transaction_")
 */

class TransactionController extends AbstractController
{
  public function __construct(TransactionsRepository $repository)
  {
    $this->repository = $repository;
  }
  /**
   * @Route("/", name="index", methods={"GET"})
   */
  public function index(): Response
  {
    $transactions = $this->repository->findAll();

    return $this->json([
      'data' => $transactions
    ]);
  }

    /**
   * @Route("/{transactionId}", name="show", methods={"GET"})
   */

  public function show($transactionId,  Request $request) {
    $data = $request->request->all();

    $transaction = $this->repository->findOneBy(['id' => $transactionId]);

    return $this->json([
      'data' => $transaction
    ]);
   }

      /**
   * @Route("/", name="create", methods={"POST"})
   */

  public function create(Request $request) {
    $data = $request->request->all();

    $transaction = new Transactions();
    $transaction->setBankBalance($data['bankBalance']);

    $doctrine = $this->getDoctrine()->getManager();

    $doctrine->persist($transaction);
    $doctrine->flush();
    return $this->json([
      'data' => 'Transação criado com suceso!'
    ]);
  }

  /**
   * @Route("/{transactionId}", name="update", methods={"PUT", "PATH"})
   */

  public function update($transactionId, Request $request) {
    $data = $request->request->all();

    $transaction = $this->repository->findOneBy(['id' =>$transactionId]);
    $transaction->setBankBalance($data['bankBalance']);

    $doctrine = $this->getDoctrine()->getManager();

    $doctrine->flush();
    return $this->json([
      'data' => 'Transação atualizado com sucesso!'
    ]);
  }

  /**
   * @Route("/{transactionId}", name="delete", methods={"DELETE"})
   */

  public function delete($transactionId, Request $request) {
    $data = $request->request->all();

    $doctrine = $this->getDoctrine()->getManager();

    $transaction = $this->repository->findOneBy(['id' => $transactionId]);

    $doctrine->remove($transaction);
    $doctrine->flush();

    return $this->json([
      'data' => 'Transação deletado com sucesso!'
    ]);
  }
}
