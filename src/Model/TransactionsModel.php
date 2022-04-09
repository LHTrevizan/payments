<?php

namespace App\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionsRepository;
use App\Repository\UserRepository;
use App\Repository\UserTypeRepository;
use App\Entity\Transactions;
use App\Entity\User;
use App\Service\Mocks;

Class TransactionsModel {

    public function __construct(TransactionsRepository $repository, UserRepository $userRepository,
        UserTypeRepository $userTypeRepository, EntityManagerInterface $em)
    {
        $this->repository         = $repository;
        $this->userRepository     = $userRepository;
        $this->userTypeRepository = $userTypeRepository;
        $this->em                 = $em;
    }

    public function findAllTransaction() {
        return $this->repository->findAll();
    }

    public function findTransactionById($transactionId) {
        return $this->repository->findOneById($transactionId);
    }

    public function transaction(array $data, string $transactionType = 'payment')
    {
        $transaction = new Transactions();

        $payee = $this->userRepository->findOneById($data['payee']);
        $payer = $this->userRepository->findOneById($data['payer']);

        if (!$this->isTransactionsAvailable($payer, $data, $transactionType)) {
            return ['message' => 'Verify your bank balance and remember you cant be a shopkeeper'];
        };

        if(!$this->isServiceAbleToMakeTransaction()) {
            return ['error' => 'Service is not responding. Try again later.'];
        }

        $transaction->setValue($data['value']);
        $transaction->setPayer($payer);
        $transaction->setPayee($payee);
        $transaction->setTransactionType($transactionType);
        $this->updateBankBalance($payee, $payer, $data['value']);

        $this->em->persist($transaction);
        $this->em->flush();
        $notification =  $this->sendNotification($payee);

        return ['message' => 'Transaction criada com sucesso!', 'Notificacao' => $notification];
    }

    public function updateBankBalance(User $payee, User $payer, float $value) {
        $some = $payee->getBankBalance() + $value;
        $payee->setBankBalance($some);

        $subtract = $payer->getBankBalance() - $value;
        $payer->setBankBalance($subtract);

        $this->em->persist($payee);
        $this->em->persist($payer);
        $this->em->flush();
    }

    public function refound(Int $transactionId) {
        $currentTransaction = $this->repository->findOneById($transactionId);

        $value   =  $currentTransaction->getValue();
        $payeeId = $currentTransaction->getPayee()->getId();
        $payerId = $currentTransaction->getPayer()->getId();

        return $this->transaction(['payee' => $payerId, 'payer' => $payeeId, 'value' => $value], 'refound');
    }

    public function isTransactionsAvailable(User $payer, array $data, string $transactionType)
    {
        if ($payer->getUserType()->getName() === 'Lojista' && $transactionType === 'payment') {
            return false;
        }

        if ($payer->getBankBalance() < $data['value']) {
            return false;
        }

        return true;
    }

    private function isServiceAbleToMakeTransaction(): bool
    {
        $paymentValidationMock = new Mocks();
        $service = $paymentValidationMock->validationPayment();
        return $service['message'] == 'Autorizado';
    }

    private function sendNotification(User $payee)
    {
        $notificationMock = new Mocks();
        return $notificationMock->notifyUser($payee->getId());
    }
}