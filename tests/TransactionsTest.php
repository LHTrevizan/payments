<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Transactions;
use App\Entity\User;
use App\Entity\UserType;
use App\Model\TransactionsModel;

class TransactionsTest extends TestCase
{
    public function testeIsTransactionsIsNotAvailableToLojista()
    {
         $transaction = $this->getMockBuilder(TransactionsModel::class)
                             ->setMethodsExcept(['isTransactionsAvailable'])->disableOriginalConstructor()
                             ->getMock();
        $user = new User();
        $user->setBankBalance(20);
        $user->setUserType((new UserType)->setName('Lojista'));
        $data = ['value'=> 200];
        $test = $transaction->isTransactionsAvailable($user, $data, 'payment' );

        $this->assertFalse($test);
    }

    public function testeIsTransactionsAvailableWithouBankBalance()
    {
         $transaction = $this->getMockBuilder(TransactionsModel::class)
                              ->setMethodsExcept(['isTransactionsAvailable'])->disableOriginalConstructor()
                              ->getMock();
        $user = new User();
        $user->setBankBalance(20);
        $user->setUserType((new UserType)->setName('Lojista'));
        $data = ['value'=> 200];
        $test = $transaction->isTransactionsAvailable($user, $data, 'payment' );

        $this->assertFalse($test);
    }

    public function testeIsTransactionsAvailable()
    {
         $transaction = $this->getMockBuilder(TransactionsModel::class)
                             ->setMethodsExcept(['isTransactionsAvailable'])->disableOriginalConstructor()
                             ->getMock();
        $user = new User();
        $user->setBankBalance(250);
        $user->setUserType((new UserType)->setName('Normal'));
        $data = ['value'=> 200];
        $test = $transaction->isTransactionsAvailable($user, $data, 'payment' );

        $this->assertTrue($test);
    }
}
