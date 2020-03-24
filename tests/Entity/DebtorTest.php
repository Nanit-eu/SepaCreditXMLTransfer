<?php

namespace App\Tests\Entity;

use NanitEu\SepaCreditXMLTransfer\Entity\Debtor;
use PHPUnit\Framework\TestCase;

class DebtorTest extends TestCase
{
    public function testDebtor()
    {
        $debtor= new Debtor('','','');
        $this->assertFalse($debtor->isValid());
        $debtor->setOrgName('test');
        $this->assertTrue($debtor->getOrgName()=='test');
        $this->assertFalse($debtor->isValid());
        $debtor->setOrgIban('BE13001319659839');
        $this->assertTrue($debtor->getOrgIban()=='BE13001319659839');
        $this->assertFalse($debtor->isValid());
        $debtor->setOrgBic('GEBABEBB');
        $this->assertTrue($debtor->getOrgBic()=='GEBABEBB');
        $this->assertTrue($debtor->isValid());
    }
}