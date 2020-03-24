<?php

namespace App\Tests\Models;

use NanitEu\SepaCreditXMLTransfer\Example\MyTransaction;
use PHPUnit\Framework\TestCase;

class TransactionModelTest extends TestCase
{
    public function testTransactionModel()
    {
        $transaction= new MyTransaction('test name', 2.54, 'BE13001319659839', 'GEBABEBB', 'transaction 1');
        $this->assertTrue($transaction->isValid());
        // bad amount
        $transaction= new MyTransaction('test name', 0, 'BE13001319659839', 'GEBABEBB', 'transaction 1');
        $this->assertFalse($transaction->isValid());
        // bad iban
        $transaction= new MyTransaction('test name', 10, 'BE1300131965989', 'GEBABEBB', 'transaction 1');
        $this->assertFalse($transaction->isValid());
        // no bic
        $transaction= new MyTransaction('test name', 10, 'BE13001319659839', '', 'transaction 1');
        $this->assertFalse($transaction->isValid());
        // don't care about communication
        $transaction= new MyTransaction('test name', 10, 'BE13001319659839', 'GEBABEBB', '');
        $this->assertTrue($transaction->isValid());
    }
}